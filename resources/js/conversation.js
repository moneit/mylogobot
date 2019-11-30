import historyHelper from "./helpers/historyHelper";

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

window.Vue = require('vue');
import BotUI from 'botui'

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import BackLinkMixin from './mixins/BackLink.js';

const app = new Vue({
  el: '#app',
  store: require('./store').default,
  mixins: [BackLinkMixin],
});

import lsHelper from './helpers/localStorageHelper.js';
import { RECOMMENDATIONS_PAGE, LANDING_PAGE } from './services/routing/pages.js';
import router from './services/routing/router.js';

(function() {
  let logoInfo = lsHelper.get('logoInfo');
  if (!logoInfo || !logoInfo.companyName) router.goToPage(LANDING_PAGE);

  const botUi = new BotUI('bot-ui-chat');

  const randomize = function() {
    return Math.floor(Math.random() * 3);
  };

  let welcomeMessages = [
    `Hi! Nice to meet you! My name is BOT and I’ll design ${logoInfo.companyName}’s new logo! Let’s go for it!`,
    `It will be a pleasure to help to create a logo for ${logoInfo.companyName}! I’m BOT, the logo designer at your service! So, let’s start to work!`,
    `So you need a logo for ${logoInfo.companyName}, right? I’m the guy to… sorry, I’m the BOT to help you with that! Let’s get started!`,
  ];

  let q1Keywords = [
    'To understand more about your business, could you tell me up to 3 keywords related to your company?',
    'If you could summarize your company’s activities in 3 words, what would they be?',
    'First, give me 3 keywords you think are important about your business.',
  ];

  let q1Answers = [
    'Ok, I think I can do that!',
    'Nice, I’m already thinking of the best options for you!',
    'Well… This could be kinda tricky but I will do my best!',
  ];

  let q2Answers = [
    'Hmm... I like it!',
    'Good business has great slogans. This is one of them!',
    'Nice slogan!',
  ];

  let finalMessages = [
    'Now I have enough to start designing your logo. I will come back in a few seconds with great logos!',
    'Let’s stop talking and start working! Wait a few seconds and I will show you the first logos soon.',
    'I already have something in mind for you! Grab a coffee and in a few seconds, you’ll see it.',
  ];

  let keyWords = [];

  botUi.message.add({
    content: welcomeMessages[randomize()]
  }).then(function() {
    botUi.message.add({
      delay: 2000,
      loading: true,
      content: q1Keywords[randomize()],
    }).then(function() {
      botUi.message.add({
        type: 'html',
        cssClass: 'tags-input',
        content: '<div id="tags-input-wrapper"><div id="tags-input-box"><input id="tags-input" placeholder="Type your answer here" required="required" /></div><div class="tags-input-box-helper">Separate tags with Space or Comma, then press Enter when it\'s done</div></div>'
      }).then(index => {
        let tagsInputBox = document.getElementById('tags-input-box');
        let tagsInput = document.getElementById('tags-input');

        function toBlock(value) {
          let trimmedValue = value.trim();
          if (trimmedValue) {
            let keyWord = trimmedValue.replace(/\d|`|~|!|@|#|\$|%|\^|&|\*|\(|\)|-|_|\+|=|{|}|\[|]|:|;|"|'|\|\\|\/|\?|<|>|,|\./gi, '');

            keyWords.push(keyWord);
            let idx = keyWords.length;
            let newNode = document.createElement('span');
            newNode.classList.add('keyword');
            newNode.appendChild(document.createTextNode(keyWord));

            let x = document.createElement('i');
            x.classList.add('logobot-icon');
            x.classList.add('icon-times-circle');
            x.classList.add('pointer');

            x.addEventListener('click', function() {
              newNode.remove();
              keyWords.splice(idx - 1, 1);
            });
            newNode.appendChild(x);
            tagsInputBox.insertBefore(newNode, tagsInput);
          }

          tagsInput.value = tagsInput.value.substring(value.length);
        }

        tagsInput.addEventListener('keyup', e => {
          let key = e.key || e.keyCode;

          if (key === "Enter" || key === 13) {
            toBlock(tagsInput.value.trim());
            // botUi.message.remove(index);
            let tagsInputWrapper = document.getElementsByClassName('tags-input')[0];
            tagsInputWrapper.setAttribute('style', 'display: none;');

            let content = keyWords.map(keyword => `<span class="keyword">${keyword}</span>`).join('');
            botUi.message.add({
              type: 'html',
              human: true,
              cssClass: 'tags-input-done',
              content: content
            }).then((block) => {
              botUi.message.add({
                delay: 0,
                loading: false,
                content: 'Can I use these keywords or do you want to edit them?',
              }).then(function (idx) {
                botUi.action.button({
                  action: [
                    {
                      text: 'Yes',
                      value: 1
                    },
                    {
                      text: 'Edit',
                      value: 0
                    }
                  ]
                }).then(function (res) {
                  if (res.value) {
                    lsHelper.set('logoInfo', {
                      companyDetails: keyWords.join(' ')
                    });

                    botUi.message.add({
                      delay: 2000,
                      loading: true,
                      content: q1Answers[randomize()],
                    }).then(function () {
                      botUi.message.add({
                        delay: 2000,
                        loading: true,
                        content: 'Do you want to use slogan?',
                      }).then(function () {
                        botUi.action.button({
                          action: [
                            {
                              text: 'Yes',
                              value: 1
                            },
                            {
                              text: 'No',
                              value: 0
                            }
                          ]
                        }).then(function (res) {
                          if (res.value) {
                            botUi.message.add({
                              delay: 2000,
                              loading: true,
                              content: 'So, give me your best slogan.',
                            }).then(function () {
                              botUi.action.text({
                                action: {
                                  placeholder: 'Type your answer here'
                                }
                              }).then(function (res) {
                                lsHelper.set('logoInfo', {
                                  slogan: res.value
                                });

                                botUi.message.add({
                                  delay: 2000,
                                  loading: true,
                                  content: q2Answers[randomize()],
                                }).then(function () {
                                  goToFinalMessage();
                                });
                              });
                            });
                          } else {
                            goToFinalMessage();
                          }

                          function goToFinalMessage() {
                            botUi.message.add({
                              delay: 2000,
                              loading: true,
                              content: finalMessages[randomize()],
                            }).then(function () {
                              botUi.action.button({
                                action: [
                                  {
                                    text: 'Show me designs',
                                    value: 1
                                  },
                                ]
                              }).then(function () {
                                lsHelper.set('logoInfo', {
                                  layout: ['icon']
                                });
                                router.goToPage(RECOMMENDATIONS_PAGE);
                              });
                            });
                          }
                        });
                      });
                    });
                  } else {
                    botUi.message.remove(idx);
                    botUi.message.remove(idx);
                    botUi.message.remove(block);
                    tagsInputWrapper.setAttribute('style', '');
                  }
                });
              });
            });
          }
        });

        tagsInput.addEventListener('input', e => {
          let input = e.data;

          if (input === " ") { // space
            toBlock(tagsInput.value);
          }
        })
      });
    });
  });
})();