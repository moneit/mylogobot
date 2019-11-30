
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


const validators = {
    email: new RegExp(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/),
    url : new RegExp(/^(https?|ftp|rmtp|mms):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(:(\d+))?\/?/i),
    text : new RegExp(/^[a-zA-Z]+$/),
    digits : new RegExp(/^[\d() \.\:\-\+#]+$/),
    isodate : new RegExp(/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/)
}

window.post_cache = {};

const input_tag = Vue.extend({
    template: '#input-tag',
    props: {
        tags: {
            type: Array,
            default: function(){ return [] }
        },
        placeholder: {
            type: String,
            default: 'Type a word then hit Enter'
        },
        onChange: {
            type: Function
        },
        readOnly: {
            type: Boolean,
            default: false
        },
        validate: {
            type: String,
            default: ''
        }
    },
    data: function() {
        return {
            newTag: ''
        }
    },
    methods: {
        focusNewTag: function() {
            if (this.readOnly) { return }
            this.$el.querySelector('.new-tag').focus()
        },
        addNew: function(tag) {
            if (tag && this.tags.indexOf(tag) === -1 && this.validateIfNeeded(tag)) {
                var trimmed = tag.replace(/(^[,\s]+)|([,\s]+$)/g, '');
                if(!trimmed){
                    return false;
                }
                this.tags.push(trimmed)
                this.tagChange()
            }
            this.newTag = ''
        },
        addString: function(s){
            if(!s){
                return false;
            }
            var t = s.split(',');

            for(var i=0; i<t.length; i++){
                this.addNew(t[i]);
            }
        },
        validateIfNeeded: function(tagValue) {
            if (this.validate === '' || this.validate === undefined) {
                return true
            }else if (Object.keys(validators).indexOf(this.validate) > -1) {
                return validators[this.validate].test(tagValue)
            }
            return true
        },
        remove: function(index) {
            this.tags.splice(index, 1)
            this.tagChange()
        },
        removeLastTag: function() {
            if (this.newTag) { return }
            this.tags.pop()
            this.tagChange()
        },
        tagChange: function() {
            if (this.onChange) {
                // avoid passing the observer
                this.onChange(JSON.parse(JSON.stringify(this.tags)))
            }
        }
    }
});

const logo_basic = Vue.extend({
    props: {
        'title': {
            type: 'String',
            required: true
        },
        'tagline': {
            type: 'String',
            default: function () {	return '' }
        },
        'titleFamily': {
            type: 'String',
            default: function () { return 'Montserrat' }
        },
        'titleVariant': {
            type: 'String',
            default: function () { return '600'	}
        },
        'taglineFamily': {
            type: 'String',
            default: function () { return 'Lora' }
        },
        'taglineVariant': {
            type: 'String',
            default: function () {return 'italic' }
        },
        'titleColor': {
            type: 'Object',
            default: function(){ return { hex: '#ffffff' } }
        },
        'taglineColor': {
            type: 'Object',
            default: function(){ return { hex: '#ffffff' } }
        },
        'backgroundColor': {
            type: 'Object',
            default: function(){ return { hex: '#000000'} }
        },
        'titleScale': {
            type: 'Number',
            default: function(){ return 1.8 }
        },
        'titleLetterSpace': {
            type: 'Number',
            default: function(){ return 0 }
        },
        'titleLineSpace': {
            type: 'Number',
            default: function(){ return 1.2 }
        },
        'taglineScale': {
            type: 'Number',
            default: function(){ return 1 }
        },
        'taglineLetterSpace': {
            type: 'Number',
            default: function(){ return 0 }
        },
        'taglineLineSpace': {
            type: 'Number',
            default: function(){ return 1.2 }
        },
        'palette': {
            type: 'Array',
            default: function(){ return [] }
        },
        'autoScale': {
            type: 'Boolean',
            default: function(){ return false }
        }
    },
    watch: {
        title: function(){
            this.getLogoThrottled();
        },
        tagline: function(){ this.getLogoThrottled() },
        titleFamily: function(){ this.getLogo() },
        titleVariant: function(){ this.getLogo() },
        taglineFamily: function(){ this.getLogo() },
        taglineVariant: function(){ this.getLogo() },
        titleColor: function () { this.update() },
        titleScale: function () { this.update() },
        titleLetterSpace: function () { this.update() },
        titleLineSpace: function () { this.update() },
        taglineColor: function () { this.update() },
        taglineScale: function () { this.update() },
        taglineLetterSpace: function () { this.update() },
        taglineLineSpace: function () { this.update() },
        backgroundColor: function () { this.update() }
    },
    data: function() {
        return {
            loaded: false,
            bbox: false,
            svg: ''
        }
    },
    template: '#logo',
    created: function() {
        this.getLogo();
    },
    updated: function(){
        this.defaultUpdate();
    },
    methods: {
        getLogo: function() {
            var post = this.$props;
            post.template = this.$options._componentTag;

            var key = String(JSON.stringify(post).hashCode());
            if(window.post_cache && window.post_cache.hasOwnProperty(key)){
                this.$nextTick(function () {
                    this.process(window.post_cache[key]);
                })
            }
            else{
                $.ajax({
                    url : 'logo.php',
                    type : 'POST',
                    data :  {data: post},
                    dataType: 'json',
                    tryCount : 0,
                    retryLimit : 3,
                    success : function(result) {
                        if(!result){
                            this.tryCount++;
                            if (this.tryCount <= this.retryLimit) {
                                //try again
                                $.ajax(this);
                                mixpanel.track("Batch Error 200", {'retry': this.tryCount});
                                return;
                            }
                            mixpanel.track("Batch Error 200", {'retry': -1});
                            return;
                        }

                        window.post_cache[key] = result;
                        this.process(result);
                    }.bind(this),
                    error : function(xhr, textStatus, errorThrown ) {
                        if(textStatus === 'abort') {
                            return false;
                        }
                        this.tryCount++;
                        if (this.tryCount <= this.retryLimit) {
                            //try again
                            mixpanel.track("Batch Error", {'retry': this.tryCount, 'status': textStatus, 'error': errorThrown, 'msg': xhr.responseJSON});

                            $.ajax(this);
                            return;
                        }
                        mixpanel.track("Batch Error", {'retry': -1, 'status': textStatus, 'error': errorThrown, 'msg': xhr.responseJSON});
                    },
                    timeout: 60000
                });
            }
        },
        getLogoThrottled: _throttle(function(){
            // todo: not sure how to reference this.getLogo here
            var post = this.$props;
            post.template = this.$options._componentTag;

            var key = String(JSON.stringify(post).hashCode());
            if(window.post_cache && window.post_cache.hasOwnProperty(key)){
                this.$nextTick(function (){
                    this.process(window.post_cache[key]);
                })
            }
            else{
                $.ajax({
                    url : 'logo.php',
                    type : 'POST',
                    data :  {data: post},
                    dataType: 'json',
                    tryCount : 0,
                    retryLimit : 3,
                    success : function(result) {
                        if(!result){
                            this.tryCount++;
                            if (this.tryCount <= this.retryLimit) {
                                //try again
                                $.ajax(this);
                                mixpanel.track("Batch Error 200", {'retry': this.tryCount});
                                return;
                            }
                            mixpanel.track("Batch Error 200", {'retry': -1});
                            return;
                        }

                        window.post_cache[key] = result;
                        this.process(result);
                    }.bind(this),
                    error : function(xhr, textStatus, errorThrown ) {
                        if(textStatus === 'abort'){
                            return false;
                        }
                        this.tryCount++;
                        if (this.tryCount <= this.retryLimit) {
                            //try again
                            mixpanel.track("Batch Error", {'retry': this.tryCount, 'status': textStatus, 'error': errorThrown, 'msg': xhr.responseJSON});

                            $.ajax(this);
                            return;
                        }
                        mixpanel.track("Batch Error", {'retry': -1, 'status': textStatus, 'error': errorThrown, 'msg': xhr.responseJSON});
                    },
                    timeout: 60000
                });
            }
        }, 500, {leading: false}),
        defaultUpdate: function(){
            $(this.$el).find('#title path').css('fill', this.titleColor.hex);
            $(this.$el).find('#tagline path').css('fill', this.taglineColor.hex);
            $(this.$el).find('.logo-inner').css('background-color', this.backgroundColor.hex);
        },
        defaultProcess: function(result){
            this.svg = result.svg;

            var bbox = [];
            var prevb = false;

            for(var i=0; i<result.elements.length; i++){
                var b = result.elements[i];

                var bb = {
                    id: b[0],
                    x: parseFloat(b[1]),
                    y: parseFloat(b[2]),
                    width: parseFloat(b[3]),
                    height: parseFloat(b[4]),
                };

                if(i > 0 && prevb && bb.id.substr(0,4) === 'path' && prevb.id.substr(0,4) === 'path'){
                    bb.kerning = bb.x-(prevb.x+prevb.width); // investigated: distance between 2 paths
                }

                prevb = bb;
                bbox.push(bb);
            }

            this.bbox = bbox;
        },
        getBox: function(id){
            if(!this.bbox){
                return false;
            }
            for(var i=0; i<this.bbox.length; i++){
                if(this.bbox[i].id == id){
                    return this.bbox[i];
                }
            }

            return false;
        },
        getCharBox: function(key){
            var chars = [];
            var found = false;

            for(var i=0; i<this.bbox.length; i++){
                if(this.bbox[i].id == key){
                    found = true;
                }
                else{
                    if(found){
                        if(this.bbox[i].id.substr(0,4) == 'path' || this.bbox[i].id.substr(0,4) == 'icon'){
                            if(this.bbox[i].width < 0.000001 || this.bbox[i].height < 0.000001){
                                continue;
                            }
                            chars.push(this.bbox[i]);
                        }
                        else{
                            break;
                        }
                    }
                }
            }

            return chars;
        },
        defaultScale: function(){
            if(!this.autoScale){
                return false;
            }
            var bounds = {
                width: 1024,
                height: 700,
                x: 0,
                y: 34
            };
            var titlewrap = this.wrap('title', this.title, bounds, this.titleScale, this.titleLetterSpace, this.titleLineSpace, true);
            var titlescale = 1;

            // min width
            if(titlewrap.bounds.width < 520){
                titlescale = 520/titlewrap.bounds.width;
            }

            var taglinescale = 1;

            var taglinewrap = this.wrap('tagline', this.tagline, bounds, this.taglineScale, this.taglineLetterSpace, this.taglineLineSpace, true);
            var tscale = (titlewrap.bounds.width*titlescale)/taglinewrap.bounds.width;

            if(taglinewrap.lines.length == 1 && tscale*this.taglineScale < this.titleScale*titlescale){
                taglinescale = tscale;
            }

            // set source data scale to false, to only scale once in lifetime
            this.$emit('scale', titlescale, taglinescale);
        },
        wrap: function(key, input, bounds, scale, letterspacing, linespacing, center){
            var chars = this.getCharBox(key);

            function getwordwidth(word, scale, letterspacing){

                scale = parseFloat(scale);
                letterspacing = parseFloat(letterspacing);

                var width = 0;
                var first = true;

                for(var i=0; i<word.length; i++){
                    if(isNumeric(word[i].kerning) && !first){
                        width += (word[i].kerning + letterspacing)*scale;
                    }
                    if(word[i].width > 0.000001){
                        width += word[i].width*scale;
                        first = false;
                    }


                }

                return width;
            }

            var words = input.match(/\S+/g);

            if(!words){
                return {
                    bounds: {x: 0, y: 0, width: 0, height: 0},
                    lines: []
                }
            }
            input = input.split('');

            var blacklist = [127];
            var lines = [];
            var w = 0;

            for(var i=0; i<words.length; i++){
                var line = [];

                for(var j=0; j<words[i].length; j++){
                    var code = words[i].charCodeAt(j);
                    if(code < 33 || blacklist.includes(code)){
                        continue;
                    }
                    var c = words[i].substr(j, 1);
                    var character = chars.shift();
                    if(!character){
                        continue;
                    }
                    character.letter = c;
                    line.push(character);
                }

                var wordwidth = getwordwidth(line, scale, letterspacing);

                if(lines.length == 0){
                    lines.push(line);
                    w = wordwidth;
                }
                else if(line.length > 0){
                    if(w + (line[0].kerning+letterspacing)*scale + wordwidth > bounds.width){
                        lines.push(line);
                        w = wordwidth;
                    }
                    else{
                        lines[lines.length-1] = lines[lines.length-1].concat(line);
                        w += (line[0].kerning+letterspacing)*scale + wordwidth;
                    }
                }
            }

            var y = bounds.y;

            // offset all characters to top of svg
            var offsety = 0;
            if(lines && lines[0] && lines[0].length > 0){
                offsety = lines[0][0].y;
            }
            for(i=0; i<lines.length; i++){
                for(j=0; j<lines[i].length; j++){
                    if(lines[i][j].y < offsety){
                        offsety = lines[i][j].y;
                    }
                }
            }

            // keep track of bounds and elements
            var minx = 1024;
            var miny = 768;

            var maxx = 0;
            var maxy = 0;

            for(i=0; i<lines.length; i++){
                var x = bounds.x;

                if(center){
                    x = bounds.x + (bounds.width-getwordwidth(lines[i], scale, letterspacing))/2;
                }

                if(x < minx){
                    minx = x;
                }

                var maxheight = 0;
                for(j=0; j<lines[i].length; j++){

                    var letter = lines[i][j];

                    if(j > 0 && letter.kerning && typeof letter.kerning != 'undefined'){
                        x += (letter.kerning+parseFloat(letterspacing))*scale;
                    }

                    // svg applies rightmost transform first!
                    $(this.$el).find('#'+letter.id).attr('transform','translate('+x+' '+(y + letter.y*scale - offsety)+') scale('+scale+') translate('+(-letter.x)+' '+(-letter.y)+')');

                    x += letter.width*scale;

                    if(letter.height*scale > maxheight){
                        maxheight = letter.height*scale;
                    }

                    if(y + letter.y*scale - offsety < miny){
                        miny = y + letter.y*scale - offsety;
                    }
                    if(y + letter.y*scale - offsety + letter.height*scale > maxy){
                        maxy = y + letter.y*scale - offsety + letter.height*scale;
                    }
                    if(x > maxx){
                        maxx = x;
                    }
                }

                y += maxheight*linespacing;
            }

            return {
                bounds: {x: minx, y: miny, width: maxx-minx, height: maxy-miny},
                lines: lines
            }
        },

        distribute: function(items, spacing, globalbounds){
            if(!globalbounds){
                globalbounds = {x: 0, y:0, width: 1024, height: 768};
            }

            // overall bounds and center
            var height = 0;

            for(var i=0; i<items.length; i++){
                height += items[i].bounds.height;

                if(i > 0 && items[i].bounds.height > 0){
                    height += spacing[i-1];
                }
            }

            var y = globalbounds.y + (globalbounds.height - height)/2;

            for(i=0; i<items.length; i++){
                var offset = y - items[i].bounds.y;

                for(var j=0; j<items[i].lines.length; j++){
                    for(var k=0; k<items[i].lines[j].length; k++){
                        var letter = items[i].lines[j][k];
                        var el = $(this.$el).find('#'+letter.id);
                        var existing = el.attr('transform');
                        if(!existing){
                            existing = '';
                        }
                        el.attr('transform', 'translate(0 '+offset+') '+existing);
                    }
                }

                y += items[i].bounds.height;
                if(i < spacing.length){
                    y += spacing[i];
                }
            }
        },
        colorImage: function(element, img, rgb){
            var canvas = document.createElement('canvas');
            canvas.width = img.width;
            canvas.height = img.height;

            var ctx = canvas.getContext('2d');
            //ctx.clearRect(0, 0, 200, 200);
            ctx.drawImage(img, 0, 0, img.width, img.height);

            var imgData = ctx.getImageData(0,0,img.width,img.height);
            var data = imgData.data;

            for(var j=0; j<data.length; j+=4) {
                data[j] = rgb.r;
                data[j+1] = rgb.g;
                data[j+2] = rgb.b;
            }

            ctx.putImageData(imgData, 0, 0);

            base64 = canvas.toDataURL();
            //element.removeAttr('xlink:href');
            //element.attr('href', base64);
            var e = element.get(0);
            if(e){
                e.setAttribute('xlink:href', base64);
            }
        }
    }
})

const logo_vertical = logo_basic.extend({
    methods: {
        process: function(result){
            var r = this.defaultProcess(result);
            this.defaultScale();
            this.loaded = true;
            return r;
        },
        update: function(){
            this.defaultUpdate();

            var title = $(this.$el).find('#title');
            var tagline = $(this.$el).find('#tagline');


            var titlebox = this.getBox('title');

            var titlewrap = this.wrap('title', this.title, {x: 50, y: 50, width: 924, height: 668}, this.titleScale, this.titleLetterSpace, this.titleLineSpace, true);
            var taglinewrap = this.wrap('tagline', this.tagline, {x: 50, y: 50, width: 924, height: 668}, this.taglineScale, this.taglineLetterSpace, this.taglineLineSpace, true);

            // align
            this.distribute([titlewrap,taglinewrap], [24*this.taglineLineSpace]);
        }
    },
    updated: function(){
        // this is where the layout happens
        this.$nextTick(function (){
            this.update();
        })
    }
});

const logo_vertical_icon = logo_basic.extend({
    props: {
        'iconId': {
            type: 'Number',
            required: true
        },
        'hideIcon': {
            type: 'Boolean',
            default: function(){ return false }
        },
        'iconScale': {
            type: 'Number',
            default: function(){ return 1 }
        },
        'iconColor': {
            type: 'String',
            default: function(){ return { hex: '#ffffff' } }
        },
    },
    watch: {
        iconId: function(){ this.getLogo() },
        hideIcon: function () { this.update() },
        iconScale: function () { this.update() },
        iconColor: function () { this.update() }
    },
    methods: {
        process: function(result){
            var self = this;

            var icon_url = '../nounpreview/'+this.iconId+'.png';
            var img = new Image();
            img.onload = function() {
                self.defaultProcess(result);
                self.defaultScale();
                self.loaded = true;
            }
            img.src = icon_url;

            return false;
        },
        update: function(){
            this.defaultUpdate();

            var titlewrap = this.wrap('title', this.title, {x: 50, y: 50, width: 924, height: 668}, this.titleScale, this.titleLetterSpace, this.titleLineSpace, true);
            var taglinewrap = this.wrap('tagline', this.tagline, {x: 50, y: 50, width: 924, height: 668}, this.taglineScale, this.taglineLetterSpace, this.taglineLineSpace, true);

            var icon = $(this.$el).find('#icon');
            if(this.hideIcon){
                icon.hide();
                this.distribute([titlewrap,taglinewrap], [18*this.taglineLineSpace]);
            }
            else{
                // center icon
                icon.show();
                var dim = 150*this.iconScale;
                icon.attr('x', 512 - dim/2);
                icon.attr('y', 0);
                icon.attr('width', dim);
                icon.attr('height', dim);

                var iconwrap = {
                    bounds: {x: 512-dim/2, y: 0, width: dim, height: dim},
                    lines: [[{
                        id: 'icon',
                        x: 512-dim/2,
                        y: 0,
                        width: dim,
                        height: dim
                    }]]
                };

                icon.removeAttr('transform');
                this.distribute([iconwrap, titlewrap,taglinewrap], [18*this.titleLineSpace,18*this.taglineLineSpace]);

                // color icon
                var self = this;
                var icon_url = '../nounpreview/'+this.iconId+'.png';
                var img = new Image();
                img.onload = function(){
                    self.colorImage(icon,img,tinycolor(self.iconColor.hex).toRgb());
                }
                img.src = icon_url;
            }
        }
    },
    updated: function(){
        this.$nextTick(function (){
            this.update();
        })
    }
});

const logo_horizontal_icon = logo_basic.extend({
    props: {
        'iconId': {
            type: 'Number',
            required: true
        },
        'hideIcon': {
            type: 'Boolean',
            default: function(){ return false }
        },
        'iconScale': {
            type: 'Number',
            default: function(){ return 1 }
        },
        'iconSpace': {
            type: 'Number',
            default: function(){ return 1 }
        },
        'iconColor': {
            type: 'String',
            default: function(){ return { hex: '#ffffff' } }
        },
    },
    data: function(){
        return {
            iconBox: false
        }
    },
    watch: {
        iconId: function(){ this.getLogo() },
        hideIcon: function () { this.update() },
        iconScale: function () { this.update() },
        iconColor: function () { this.update() },
        iconSpace: function () { this.update() }
    },
    methods: {
        process: function(result){
            var self = this;
            self.iconBox = result.iconbox;

            var icon_url = '../nounpreview/'+this.iconId+'.png';
            var img = new Image();
            img.onload = function(){
                self.defaultProcess(result);
                self.scale();
                self.loaded = true;
            }
            img.src = icon_url;

            return false;
        },
        scale: function(){
            if(!this.autoScale){
                return false;
            }
            var icon_width = 150*this.iconScale*(this.iconBox.width/200);
            var icon_height = 150*this.iconScale*(this.iconBox.height/200);
            var spacing = 50*this.iconSpace;

            var titlespace = 900-icon_width-spacing;

            var bounds = {
                x: 0,
                y: 0,
                width: titlespace,
                height: 700
            };

            var titlewrap = this.wrap('title', this.title, bounds, this.titleScale, this.titleLetterSpace, this.titleLineSpace, false);
            var titlescale = 1;

            // min width
            if(titlewrap.bounds.width < 420){
                titlescale = 420/titlewrap.bounds.width;
            }

            if(titlewrap.bounds.width > titlespace){
                titlescale = titlespace/titlewrap.bounds.width;
            }

            var taglinescale = 1;

            var taglinewrap = this.wrap('tagline', this.tagline, bounds, this.taglineScale, this.taglineLetterSpace, this.taglineLineSpace, false);
            var tscale = (titlewrap.bounds.width*titlescale)/taglinewrap.bounds.width;

            if(taglinewrap.lines.length == 1 && tscale*this.taglineScale < this.titleScale*titlescale){
                taglinescale = tscale;
            }

            // align icon vertically
            var iconscale = 1;
            var textheight = titlewrap.bounds.height*titlescale;
            if(this.tagline && taglinewrap.bounds.height > 0){
                textheight += taglinewrap.bounds.height*taglinescale + 18*this.taglineLineSpace;
            }
            iconscale = textheight/icon_height;

            var finalwidth = iconscale*icon_width + spacing + titlewrap.bounds.width*titlescale;
            if(finalwidth > 800){
                titlescale *= 800/finalwidth;
                taglinescale *= 800/finalwidth;
                iconscale *= 800/finalwidth;
            }

            this.$emit('scale', titlescale, taglinescale, iconscale);
        },
        update: function(){
            this.defaultUpdate();

            // center icon
            var icon = $(this.$el).find('#icon');

            if(this.hideIcon){
                icon.hide();
                var titlewrap = this.wrap('title', this.title, {x: 50, y: 50, width: 924, height: 668}, this.titleScale, this.titleLetterSpace, this.titleLineSpace, true);
                var taglinewrap = this.wrap('tagline', this.tagline, {x: 50, y: 50, width: 924, height: 668}, this.taglineScale, this.taglineLetterSpace, this.taglineLineSpace, true);
                this.distribute([titlewrap,taglinewrap], [18*this.taglineLineSpace]);
                $(this.$el).find('#logo-center').removeAttr('transform');
            }
            else{
                var icon_width = 150*this.iconScale*(this.iconBox.width/200);
                var icon_height = 150*this.iconScale*(this.iconBox.height/200);

                icon.show();
                icon.attr('x', -150*this.iconScale*(this.iconBox.offsetx/200));
                icon.attr('y', 384 - icon_height/2 - 150*this.iconScale*(this.iconBox.offsety/200));
                icon.attr('width', 150*this.iconScale);
                icon.attr('height', 150*this.iconScale);

                var spacing = 50*this.iconSpace;
                var titlewrap = this.wrap('title', this.title, {x: icon_width+spacing, y: 50, width: 950-icon_width, height: 668}, this.titleScale, this.titleLetterSpace, this.titleLineSpace, false);
                var taglinewrap = this.wrap('tagline', this.tagline, {x: icon_width+spacing, y: 50, width: 950-icon_width, height: 668}, this.taglineScale, this.taglineLetterSpace, this.taglineLineSpace, false);

                icon.removeAttr('transform');
                this.distribute([titlewrap,taglinewrap], [18*this.taglineLineSpace]);

                $(this.$el).find('#logo-center').attr('transform', 'translate('+0.5*(1024-icon_width-titlewrap.bounds.width-spacing)+' 0)');

                // color icon
                var self = this;
                var icon_url = '../nounpreview/'+this.iconId+'.png';
                var img = new Image();
                img.onload = function(){
                    self.colorImage(icon,img,tinycolor(self.iconColor.hex).toRgb());
                }
                img.src = icon_url;
            }
        }
    },
    updated: function(){
        this.$nextTick(function (){
            this.update();
        })
    }
});

const logo_icon_replacement = logo_basic.extend({
    props: {
        'iconId': {
            type: 'Number',
            required: true
        },
        'nthChar': {
            type: 'Number',
            required: true
        },
        'iconColor': {
            type: 'String',
            default: function(){ return { hex: '#ffffff' } }
        },
        'iconScale': {
            type: 'Number',
            default: function(){ return 1 }
        },
        'hideIcon': {
            type: 'Boolean',
            default: function(){ return false }
        }
    },
    data: function(){
        return {
            iconBox: false
        }
    },
    watch:{
        iconId: function(){ this.getLogo() },
        hideIcon: function(){ this.update() },
        nthChar: function(){ this.update() },
        iconColor: function(){ this.update() },
        iconScale: function(){ this.update() }
    },
    methods: {
        process: function(result){
            var self = this;
            this.iconBox = result.iconbox;
            var icon_url = '../nounpreview/'+this.iconId+'.png';
            var img = new Image();
            img.onload = function(){
                self.defaultProcess(result);
                self.scale();
                self.loaded = true;
            }
            img.src = icon_url;
            return false;
        },
        scale: function(){
            if(!this.autoScale){
                return false;
            }
            var bounds = {
                width: 1024,
                height: 700,
                x: 0,
                y: 34
            };
            var titlewrap = this.wrap('title', this.title, bounds, this.titleScale, this.titleLetterSpace, this.titleLineSpace, true);
            var titlescale = 1;

            var titlewidth = titlewrap.bounds.width;

            var index = this.get_icon_index();
            var letter = this.bbox[index];

            titlewidth -= letter.width*this.titleScale;

            var localscale = letter.height/this.iconBox.height;
            titlewidth += this.iconBox.width * localscale * this.iconScale * this.titleScale;

            // min width
            if(titlewidth < 520){
                titlescale = 520/titlewidth;
            }

            var taglinescale = 1;

            var taglinewrap = this.wrap('tagline', this.tagline, bounds, this.taglineScale, this.taglineLetterSpace, this.taglineLineSpace, true);
            if(taglinewrap.lines.length == 1 && taglinewrap.bounds.width > titlewidth*titlescale){
                taglinescale = (titlewidth*titlescale)/taglinewrap.bounds.width;
            }

            //console.log(titlescale, taglinescale, titlewidth, this.iconBox, taglinewrap.lines.length, this.$el);

            // set source data scale to false, to only scale once in lifetime
            this.$emit('scale', titlescale, taglinescale);
        },
        get_icon_index: function(){
            var found = false;
            var count = 0;
            var index = 0;
            for(var i=0; i<this.bbox.length; i++){
                if(found){
                    if(this.nthChar == count){
                        index = i;
                        break;
                    }
                    count++;
                }
                if(this.bbox[i].id == 'title'){
                    found = true;
                }
            }

            return index;
        },
        update: function(){
            this.defaultUpdate();

            if(!this.bbox){
                return false;
            }

            var index = this.get_icon_index();
            var letter = this.bbox[index];

            if(this.hideIcon){
                if(letter.id == 'icon'){
                    for(i=0; i<this.bbox.length; i++){
                        if(this.bbox[i].id == 'icon' && this.bbox[i].replaced){
                            this.bbox[i] = this.bbox[i].replaced;
                            break;
                        }
                    }
                }
                $(this.$el).find('path').show();
                $(this.$el).find('#icon').hide();
            }
            else{
                if(letter.id != 'icon'){
                    for(i=0; i<this.bbox.length; i++){
                        if(this.bbox[i].id == 'icon' && this.bbox[i].replaced){
                            this.bbox[i] = this.bbox[i].replaced;
                            break;
                        }
                    }

                    var localscale = letter.height/this.iconBox.height;

                    $(this.$el).find('path').show();
                    $(this.$el).find('#'+letter.id).hide();

                    var icon = $(this.$el).find('#icon');

                    icon.show();
                    icon.removeAttr('transform');

                    var dim = 200 * localscale * this.iconScale;

                    icon.attr('x', letter.x - this.iconBox.offsetx*localscale*this.iconScale);
                    icon.attr('y', letter.y - this.iconBox.offsety*localscale*this.iconScale - 0.5*(this.iconBox.height*localscale*(this.iconScale-1)));
                    icon.attr('width', dim);
                    icon.attr('height', dim);

                    var replacement = {
                        id: 'icon',
                        width: this.iconBox.width * localscale * this.iconScale,
                        height: letter.height * this.iconScale,
                        x: letter.x,
                        y: letter.y,
                        letter: letter.letter,
                        replaced: letter
                    };

                    if(isNumeric(letter.kerning)){
                        replacement.kerning = letter.kerning;
                    }

                    this.bbox[index] = replacement;
                }
                else if(letter.replaced){
                    $(this.$el).find('#'+letter.replaced.id).hide();

                    var icon = $(this.$el).find('#icon');
                    icon.show();
                    var localscale = letter.replaced.height/this.iconBox.height;
                    var dim = 200 * localscale * this.iconScale;

                    letter.width = this.iconBox.width * localscale * this.iconScale;
                    letter.height = letter.replaced.height * this.iconScale;

                    icon.attr('x', letter.replaced.x - this.iconBox.offsetx*localscale*this.iconScale);
                    icon.attr('y', letter.replaced.y - this.iconBox.offsety*localscale*this.iconScale - 0.5*(this.iconBox.height*localscale*(this.iconScale-1)));
                    icon.attr('width', dim);
                    icon.attr('height', dim);
                }
            }

            var titlewrap = this.wrap('title', this.title, {x: 50, y: 50, width: 924, height: 668}, this.titleScale, this.titleLetterSpace, this.titleLineSpace, true);
            var taglinewrap = this.wrap('tagline', this.tagline, {x: 50, y: 50, width: 924, height: 668}, this.taglineScale, this.taglineLetterSpace, this.titleLineSpace, true);

            this.distribute([titlewrap,taglinewrap], [24*this.taglineLineSpace]);

            // color icon
            var self = this;
            var icon_url = '../nounpreview/'+this.iconId+'.png';
            var img = new Image();
            img.onload = function(){
                self.colorImage($(self.$el).find('#icon'),img,tinycolor(self.iconColor.hex).toRgb());
            }
            img.src = icon_url;
        }
    },
    updated: function(){
        this.$nextTick(function (){
            this.update();
        })
    }
});

function hit(data, x, y){
    return data[(x + y*200)*4 + 3] > 1;
}

const logo_icon_frame = logo_basic.extend({
    props: {
        'iconId': {
            type: 'Number',
            required: true
        },
        'hideIcon': {
            type: 'Boolean',
            default: function(){ return false }
        },
        'iconScale': {
            type: 'Number',
            default: function(){ return 1 }
        },
        'iconColor': {
            type: 'String',
            default: function(){ return { hex: '#ffffff' } }
        },
        'iconBounds': {
            type: 'String',
            default: function(){ return false }
        }
    },
    data: function(){
        return {
            iconBox: false
        }
    },
    watch:{
        iconId: function(){ this.getLogo() },
        hideIcon: function(){ this.update() },
        iconColor: function(){ this.update() },
        iconScale: function(){ this.update() }
    },
    methods: {
        scale: function(){
            if(!this.autoScale){
                return false;
            }
            var dim = 640 * this.iconScale * 0.85;
            var bounds = {
                x: 0,
                y: 0,
                width: ((this.iconBox.maxx - this.iconBox.minx)/200)*dim,
                height: ((this.iconBox.maxy - this.iconBox.miny)/200)*dim
            };

            var titlewrap = this.wrap('title', this.title, bounds, this.titleScale, this.titleLetterSpace, this.titleLineSpace, true);

            //console.log('scale 2');
            // set source data scale to false, to only scale once in lifetime
            this.$emit('scale', bounds.width/titlewrap.bounds.width);
        },
        process: function(result){
            var self = this;

            var icon_url = './icon_large/?id='+this.iconId;

            var img = new Image();

            if(self.iconBounds){
                self.iconBox = self.iconBounds;
                img.onload = function(){
                    self.defaultProcess(result);
                    self.scale();
                    self.loaded = true;
                }
            }
            else{
                img.onload = function(){
                    // get frame via canvas
                    self.defaultProcess(result);
                    var canvas = document.createElement('canvas');
                    canvas.width = 200;
                    canvas.height = 200;

                    var context = canvas.getContext('2d');

                    context.drawImage(img,0,0,200,200);
                    var imgData = context.getImageData(0,0,canvas.width,canvas.height);
                    var data = imgData.data;

                    // enumerate all pixels
                    // each pixel's r,g,b,a datum are stored in separate sequential array elements
                    var maxx = 199;
                    var minx = 0;
                    var maxy = 199;
                    var miny = 0;

                    // horizontal
                    for(var x = 100; x < 200; x++) {
                        if(hit(data, x, 100)){
                            maxx = x;
                            break;
                        }
                    }
                    for(x=100; x >= 0; x--){
                        if(hit(data, x, 100)){
                            minx = x;
                            break;
                        }
                    }

                    // vertical
                    for(var y=100; y < 200; y++){
                        if(hit(data, 100, y)){
                            maxy = y;
                            break;
                        }
                    }
                    for(y=100; y >= 0; y--){
                        if(hit(data, 100, y)){
                            miny = y;
                            break;
                        }
                    }


                    // fudge factor for slants (rectangular bounds tend to be underestimated without this)
                    var f = 15;

                    // slant 1
                    for(x=100; x < 200; x++){
                        if(hit(data, x, x)){
                            if(maxx < 199 && x+f < maxx){
                                maxx = x+f;
                            }
                            if(x+f < maxy){
                                maxy = x+f;
                            }
                            break;
                        }
                    }

                    // slant 2
                    for(x=100; x >= 0; x--){
                        if(hit(data, x, x)){
                            if(minx > 0 && x-f > minx){
                                minx = x-f;
                            }
                            if(x-f > miny){
                                miny = x-f;
                            }
                            break;
                        }
                    }

                    // slant 3
                    for(x=100; x >= 0; x--){
                        if(hit(data, x, 199-x)){
                            if(minx > 0 && x-f > minx){
                                minx = x-f;
                            }
                            if((199-x)+f < maxy){
                                maxy = (199-x)+f;
                            }
                            break;
                        }
                    }

                    // slant 4
                    for(x=100; x < 200; x++){
                        if(hit(data, x, 199-x)){
                            if(maxx < 199 && x+f < maxx){
                                maxx = x+f;
                            }
                            if((199-x)-f > miny){
                                miny = (199-x)-f;
                            }
                            break;
                        }
                    }

                    self.iconBox = {
                        minx: minx,
                        maxx: maxx,
                        miny: miny,
                        maxy: maxy
                    };

                    self.scale();
                    self.loaded = true;
                }
            }
            img.src = icon_url;
            return false;
        },
        update: function(){
            this.defaultUpdate();

            var icon = $(this.$el).find('#icon');
            var dim = 640 * this.iconScale;

            icon.removeAttr('transform');

            icon.attr('x', 512 - dim/2);
            icon.attr('y', 384 - dim/2);
            icon.attr('width', dim);
            icon.attr('height', dim);

            var bounds = {
                x: (this.iconBox.minx/200)*dim + (512 - dim/2),
                y: (this.iconBox.miny/200)*dim + (384 - dim/2),
                width: ((this.iconBox.maxx - this.iconBox.minx)/200)*dim,
                height: ((this.iconBox.maxy - this.iconBox.miny)/200)*dim
            };

            //console.log('bounds', bounds, this.iconBox.minx, this.iconBox.maxx, dim);

            //var newElement = document.createElementNS("http://www.w3.org/2000/svg", 'rect'); //Create a path in SVG's namespace
            //newElement.setAttribute("x",bounds.x);
            //newElement.setAttribute("y",bounds.y);
            //newElement.setAttribute("width",bounds.width);
            //newElement.setAttribute("height",bounds.height);
            //newElement.style.fill = "none";
            //newElement.style.stroke = "#f00"; //Set stroke colour
            //newElement.style.strokeWidth = "1px"; //Set stroke width
            //$(this.$el).find('svg').get(0).appendChild(newElement);

            // shrink bounds to 0.95
            bounds.width *= 0.9;
            bounds.height *= 0.9;
            bounds.x += bounds.width*0.05;
            bounds.y += bounds.height*0.05;

            var titlewrap = this.wrap('title', this.title, bounds, this.titleScale, this.titleLetterSpace, this.titleLineSpace, true);
            var taglinewrap = this.wrap('tagline', this.tagline, bounds, this.taglineScale, this.taglineLetterSpace, this.taglineLineSpace, true);

            this.distribute([titlewrap,taglinewrap], [18*this.taglineLineSpace], bounds);

            if(this.hideIcon){
                icon.hide();
            }
            else{
                icon.show();
            }
            // color icon
            var self = this;
            var icon_url = './icon_large/?id='+this.iconId;;
            var img = new Image();
            img.onload = function(){
                self.colorImage(icon,img,tinycolor(self.iconColor.hex).toRgb());
            }
            img.src = icon_url;
        }
    },
    updated: function(){
        this.$nextTick(function (){
            this.update();
        })
    }
});


const logo_icon_frame_inverted = logo_basic.extend({
    props: {
        'iconId': {
            type: 'Number',
            required: true
        },
        'hideIcon': {
            type: 'Boolean',
            default: function(){ return false }
        },
        'iconScale': {
            type: 'Number',
            default: function(){ return 1 }
        },
        'iconColor': {
            type: 'String',
            default: function(){ return { hex: '#ffffff' } }
        },
        'iconBounds': {
            type: 'String',
            default: function(){ return false }
        },
        'autoScale': {
            type: 'Boolean',
            default: function(){ return false }
        }
    },
    data: function(){
        return {
            iconBox: false
        }
    },
    watch:{
        iconId: function(){ this.getLogo() },
        hideIcon: function(){ this.update() },
        iconColor: function(){ this.update() },
        iconScale: function(){ this.update() }
    },
    methods: {
        scale: function(){
            if(!this.autoScale){
                return;
            }

            var dim = 640 * this.iconScale * 0.85;
            var bounds = {
                x: 0,
                y: 0,
                width: ((this.iconBox.maxx - this.iconBox.minx)/200)*dim,
                height: ((this.iconBox.maxy - this.iconBox.miny)/200)*dim
            };

            var titlewrap = this.wrap('title', this.title, bounds, this.titleScale, this.titleLetterSpace, this.titleLineSpace, true);
            this.$emit('scale', bounds.width/titlewrap.bounds.width);
        },
        process: function(result){
            if(this.iconBounds){
                this.iconBox = this.iconBounds;
            }
            else{
                this.iconBox = result.iconbox;
            }
            this.defaultProcess(result);
            this.scale();
            this.loaded = true;
            return false;
        },
        update: function(){
            this.defaultUpdate();

            var icon = $(this.$el).find('#icon');
            var dim = 640 * this.iconScale;

            icon.attr('x', 512 - dim/2);
            icon.attr('y', 384 - dim/2);
            icon.attr('width', dim);
            icon.attr('height', dim);

            var bounds = {
                x: (this.iconBox.minx/200)*dim + (512 - dim/2),
                y: (this.iconBox.miny/200)*dim + (384 - dim/2),
                width: ((this.iconBox.maxx - this.iconBox.minx)/200)*dim,
                height: ((this.iconBox.maxy - this.iconBox.miny)/200)*dim
            };

            /*var newElement = document.createElementNS("http://www.w3.org/2000/svg", 'rect'); //Create a path in SVG's namespace
            newElement.setAttribute("x",bounds.x);
            newElement.setAttribute("y",bounds.y);
            newElement.setAttribute("width",bounds.width);
            newElement.setAttribute("height",bounds.height);
            newElement.style.fill = "none";
            newElement.style.stroke = "#f00"; //Set stroke colour
            newElement.style.strokeWidth = "1px"; //Set stroke width
            $(this.$el).find('svg').get(0).appendChild(newElement);*/

            // shrink bounds to 0.95
            bounds.width *= 0.9;
            bounds.height *= 0.9;
            bounds.x += bounds.width*0.05;
            bounds.y += bounds.height*0.05;

            var titlewrap = this.wrap('title', this.title, bounds, this.titleScale, this.titleLetterSpace, this.titleLineSpace, true);
            var taglinewrap = this.wrap('tagline', this.tagline, bounds, this.taglineScale, this.taglineLetterSpace, this.taglineLineSpace, true);

            this.distribute([titlewrap,taglinewrap], [18*this.taglineLineSpace], bounds);

            if(this.hideIcon){
                icon.hide();
            }
            else{
                icon.show();
            }
            // color icon
            var self = this;
            var icon_url = './icon_large/?id='+this.iconId;
            var img = new Image();
            img.onload = function(){
                self.colorImage(icon,img,tinycolor(self.iconColor.hex).toRgb());
            }
            img.src = icon_url;
        }
    },
    updated: function(){
        this.$nextTick(function (){
            this.update();
        })
    }
});


const logo_letter = logo_basic.extend({
    props: {
        'letter': {
            type: 'String',
            required: true
        },
        'hideIcon': {
            type: 'Boolean',
            default: function(){ return false }
        },
        'letterScale': {
            type: 'Number',
            default: function(){ return 3.2 }
        },
        'letterLetterSpace': {
            type: 'Number',
            default: function(){ return 0 }
        },
        'letterFamily': {
            type: 'String',
            default: function () { return 'Montserrat' }
        },
        'letterVariant': {
            type: 'String',
            default: function () { return '600'	}
        },
        'letterColor': {
            type: 'Object',
            default: function(){ return { hex: '#ffffff'} }
        }
    },
    watch:{
        letter: function(){ this.getLogo() },
        letterFamily: function(){ this.getLogo() },
        letterVariant: function(){ this.getLogo() },
        hideIcon: function(){ this.update() },
        letterScale: function(){ this.update() },
        letterLetterSpace: function(){ this.update() },
        letterColor: function(){ this.update() }
    },
    methods: {
        process: function(result){
            var r = this.defaultProcess(result);
            this.defaultScale();
            this.loaded = true;
            return r;
        },
        update: function(){
            this.defaultUpdate();

            var letterwrap = this.wrap('letter', this.letter, {x: 50, y: 50, width: 924, height: 668}, this.letterScale, this.letterLetterSpace, 1, true);
            var titlewrap = this.wrap('title', this.title, {x: 50, y: 50, width: 924, height: 668}, this.titleScale, this.titleLetterSpace, this.titleLineSpace, true);
            var taglinewrap = this.wrap('tagline', this.tagline, {x: 50, y: 50, width: 924, height: 668}, this.taglineScale, this.taglineLetterSpace, this.taglineLineSpace, true);

            if(this.hideIcon){
                this.distribute([titlewrap,taglinewrap], [18*this.taglineLineSpace]);
                $(this.$el).find('#letter').hide();
            }
            else{
                this.distribute([letterwrap,titlewrap,taglinewrap], [32*this.titleLineSpace,18*this.taglineLineSpace]);
                $(this.$el).find('#letter').show();
            }

            $(this.$el).find('#letter path').css('fill', this.letterColor.hex);
        }
    },
    updated: function(){
        this.$nextTick(function (){
            this.update();
        })
    }
});

const logo_color = logo_basic.extend({
    props: {
        'color1': {
            type: 'Object',
            default: function(){ return { hex: '#ffffff'} }
        },
        'color2': {
            type: 'Object',
            default: function(){ return { hex: '#dddddd'} }
        },
        'color3': {
            type: 'Object',
            default: function(){ return { hex: '#bbbbbb'} }
        },
        'color4': {
            type: 'Object',
            default: function(){ return { hex: '#bbbbbb'} }
        },
        'nth1': {
            type: 'Number',
            default: function(){ return 0 }
        },
        'nth2': {
            type: 'Number',
            default: function(){ return 0 }
        },
        'nth3': {
            type: 'Number',
            default: function(){ return 0 }
        },
        'nth4': {
            type: 'Number',
            default: function(){ return 0 }
        }
    },
    watch:{
        color1: function(){ this.update() },
        color2: function(){ this.update() },
        color3: function(){ this.update() },
        color4: function(){ this.update() },
        nth1: function(){ this.update() },
        nth2: function(){ this.update() },
        nth3: function(){ this.update() }
    },
    methods: {
        process: function(result){
            var r = this.defaultProcess(result);
            this.defaultScale();
            this.loaded = true;
            return r;
        },
        update: function(){
            this.defaultUpdate();

            var titlewrap = this.wrap('title', this.title, {x: 50, y: 50, width: 924, height: 668}, this.titleScale, this.titleLetterSpace, this.titleLineSpace, true);
            var taglinewrap = this.wrap('tagline', this.tagline, {x: 50, y: 50, width: 924, height: 668}, this.taglineScale, this.taglineLetterSpace, this.taglineLineSpace, true);

            this.distribute([titlewrap,taglinewrap], [18*this.taglineLineSpace]);
            $(this.$el).find('#letter').hide();

            $(this.$el).find('#title path').css('fill', this.color4.hex);

            if(this.nth3 > -1){
                $(this.$el).find('#title path').slice(0,this.nth3).css('fill', this.color3.hex);
            }
            if(this.nth2 > -1){
                $(this.$el).find('#title path').slice(0,this.nth2).css('fill', this.color2.hex);
            }
            if(this.nth1 > -1){
                $(this.$el).find('#title path').slice(0,this.nth1).css('fill', this.color1.hex);
            }
        }
    },
    updated: function(){
        this.$nextTick(function (){
            this.update();
        })
    }
});

if(window.StripeCheckout){
    var stripe_handler = StripeCheckout.configure({
        key: 'pk_live_YY4qbjrpRivlMB2peHWAxclE',
        image: 'img/logo.png',
        locale: 'auto',
        token: function(token) {
            var logo = window.brandmark.active_logo;
            logo.keywords = window.brandmark.keywords;
            token.logo_params = JSON.stringify(logo);
            token.logo = $('.logo_active .logo-inner').html();
            if(!token.logo){
                alert('sorry, a browser error occurred.');
                return;
            }

            token.tier = brandmark.purchase_tier;

            var referral = Cookies.get('referral');
            token.referral = referral;

            $.ajax({
                type: 'POST',
                url: 'charge.php',
                data: token,
                success: function(result){
                    if(result == 'success'){
                        alert('Thank you for your purchase, you\'ll receive an email in 10-15 minutes with your purchased assets!');
                        var amount = 25;
                        if(token.tier == 'designer'){
                            amount = 65;
                        }
                        else if(token.tier == 'enterprise'){
                            amount = 175;
                        }
                        ga('send', 'event', 'purchase', 'purchase', token.tier, amount);
                        mixpanel.track("Purchase complete", {'user_id': (window.brandmark.auth0_profile ? window.brandmark.auth0_profile.user_id : '')});
                    }
                    else{
                        alert('Sorry, there was a problem charging the card. If you would like to pay via paypal or another method, please email us the share link for the logo you would like to purchase: support@brandmark.io');
                    }
                },
                error: function(){
                    alert('Sorry, there was a problem charging the card. If you would like to pay via paypal or another method, please email us the share link for the logo you would like to purchase: support@brandmark.io');
                },
                dataType: 'text'
            });
        }
    });
}

var brandmark = new Vue({
    el: '#brandmark',
    data: {
        company_name: '',
        tagline: '',
        page: 'info',
        keywords: [],
        logo_index: 0,
        logo_style: 'all',
        example_mode: false,
        edit_mode: false,
        variant_mode: false,
        variant_loading: false,
        variant_logos: [],
        icon_mode: false,
        icon_loading: false,
        icons: [],
        icon_search_term: '',
        share_mode: false,
        share_url: '',
        edit_info: false,
        preview_mode: false,
        purchase_mode: false,
        title_color_show: false,
        tagline_color_show: false,
        nth1_color_show: false,
        nth2_color_show: false,
        nth3_color_show: false,
        nth4_color_show: false,
        icon_color_show: false,
        letter_color_show: false,
        background_color_show: false,
        loading_logos: false,
        loading_request: false,
        loading_colors: false,
        saved_logos: [],
        active_hue: 'blue',
        purchase_tier: 'basic',
        auth0_profile: false,
        auth0_access_token: false,
        auth0_expires: 0,
        auth0_mode: false,
        nagged: false,
        font_config:{
            weight: false,
            style: false,
            category: false,
            prefix: 'title'
        },
        hues: [
            {name: 'brown', label: '#873925'},
            {name: 'red', label: '#ec2224'},
            {name: 'orange', label: '#ee5423'},
            {name: 'yellow', label: '#ead621'},
            {name: 'green', label: '#73bf44'},
            {name: 'turquoise', label: '#61c4af'},
            {name: 'blue', label: '#3f83c4'},
            {name: 'violet', label: '#714ea0'},
            {name: 'gray', label: '#878689'}
        ],
        colors: {
            brown: [],
            red: [],
            orange: [],
            yellow: [],
            green: [],
            turquoise: [],
            blue: [],
            violet: [],
            gray: []
        },
        temp_color : false,
        selected_color_styles: [],
        logos: [
            //{"name":"logo-color","color1":{"hex":"#ffffff"},"color2":{"hex":"#dddddd"},"color3":{"hex":"#cccccc"},"color4":{"hex":"#999999"},"nth1":2,"nth2":4,"nth3":6,"nth4":0,"title":"AIMERBRAHCOOL","tagline":"","titleFamily":"Montserrat ExtraBold Alt1","titleVariant":"800","taglineFamily":"Montserrat","taglineVariant":"500","titleScale":0.76923076923076927347011633173679001629352569580078125,"taglineScale":0.76923076923076927347011633173679001629352569580078125,"titleColor":{"hex":"#02bbcd"},"taglineColor":{"hex":"#02bbcd"},"backgroundColor":{"hex":"#b44d7c"},"titleLetterSpace":7,"titleLineSpace":1.100000000000000088817841970012523233890533447265625,"taglineLetterSpace":0,"taglineLineSpace":1.100000000000000088817841970012523233890533447265625,"iconScale":1,"score":10,"autoScale":true,"palette":["#b44d7c","#02bbcd","#3f386c","#f55a44","#02bbcd","#febe76"]}
            //{"name":"logo-icon-replacement","iconId":979030,"iconColor":{"hex":"#449dc8"},"title":"BRANDMARK","tagline":"","nthChar":2,"titleFamily":"Source Serif Pro","titleVariant":"700","taglineFamily":"Source Sans Pro","taglineVariant":"regular","titleScale":1.1111111111111,"taglineScale":1.1111111111111,"titleColor":{"hex":"#449dc8"},"taglineColor":{"hex":"#449dc8"},"backgroundColor":{"hex":"#3f464a"},"titleLetterSpace":10,"titleLineSpace":1.1,"taglineLetterSpace":0,"taglineLineSpace":1.1,"iconScale":1,"score":2,"autoScale":false,"palette":["#449dc8","#f1f1f3","#3f464a","#3c3c43","#1c192c"],"token":"8b668aca11a87fa9a47dc310fb524202"}
        ],
        titleScaleOptions: {
            height: 2,
            dotSize: 12,
            min: 0.2,
            max: 6,
            interval: 0.02,
            tooltip: false,
            bgStyle: {
                background: '#7c8a95'
            },
            sliderStyle: {
                background: '#9EDFE8'
            },
            processStyle: {
                background: 'transparent'
            }
        },
        titleLetterSpaceOptions: {
            height: 2,
            dotSize: 12,
            min: -10,
            max: 25,
            interval: 0.05,
            tooltip: false,
            bgStyle: {
                background: '#7c8a95'
            },
            sliderStyle: {
                background: '#9EDFE8'
            },
            processStyle: {
                background: 'transparent'
            }
        },
        titleLineSpaceOptions: {
            height: 2,
            dotSize: 12,
            min: -0.5,
            max: 3,
            interval: 0.05,
            tooltip: false,
            bgStyle: {
                background: '#7c8a95'
            },
            sliderStyle: {
                background: '#9EDFE8'
            },
            processStyle: {
                background: 'transparent'
            }
        },
        iconScaleOptions: {
            height: 2,
            dotSize: 12,
            min: 0.3,
            max: 6,
            interval: 0.01,
            tooltip: false,
            bgStyle: {
                background: '#7c8a95'
            },
            sliderStyle: {
                background: '#9EDFE8'
            },
            processStyle: {
                background: 'transparent'
            }
        },
        iconSpaceOptions: {
            height: 2,
            dotSize: 12,
            min: -10,
            max: 10,
            interval: 0.02,
            tooltip: false,
            bgStyle: {
                background: '#7c8a95'
            },
            sliderStyle: {
                background: '#9EDFE8'
            },
            processStyle: {
                background: 'transparent'
            }
        },
        letterScaleOptions: {
            height: 2,
            dotSize: 12,
            min: 0.5,
            max: 6,
            interval: 0.1,
            tooltip: false,
            bgStyle: {
                background: '#7c8a95'
            },
            sliderStyle: {
                background: '#9EDFE8'
            },
            processStyle: {
                background: 'transparent'
            }
        },
        letterLetterSpaceOptions: {
            height: 2,
            dotSize: 12,
            min: -15,
            max: 20,
            interval: 0.1,
            tooltip: false,
            bgStyle: {
                background: '#7c8a95'
            },
            sliderStyle: {
                background: '#9EDFE8'
            },
            processStyle: {
                background: 'transparent'
            }
        }
    },
    watch: {
        company_name: function(val){
            if(!val || val === null || val === 'null'){ // todo: fix this
                val = '';
            }
            if(storage){
                window.storage.setItem('company_name', val);
            }
        },
        tagline: function(val){
            if(!val || val === null || val === 'null'){ // todo: fix this
                val = '';
            }
            if(storage){
                window.storage.setItem('tagline', val);
            }
        },
        keywords: function(val){
            if(!val){
                val = [];
            }
            if(storage){
                window.storage.setItem('keywords', JSON.stringify(val));
            }
        },
        selected_color_styles: function(val){
            if(!val){
                val = [];
            }
            if(storage){
                window.storage.setItem('selected_color_styles', JSON.stringify(val));
            }
        },
        saved_logos: function(val){
            if(!this.auth0_profile || !this.auth0_access_token){
                return false;
            }

            this.$nextTick(function (){
                var svg = [];
                $('.logo-saved .logo-inner').each(function(){
                    svg.push($(this).html());
                });

                if(svg.length == 0){
                    return false;
                }
                window.save_logos(svg, this.saved_logos, this.auth0_access_token);
            });
        }
    },
    computed: {
        displayed_logos: function(){
            var end = this.logo_index + 20;
            if(end > this.logos.length){
                end = this.logos.length;
            }
            return this.logos.slice(0, end);
        },
        active_logo: function(){
            return this.logos[this.logo_index];
        },
        inverted_logo: function(){
            var inverted = JSON.parse(JSON.stringify(this.active_logo));
            var foreground = inverted.backgroundColor.hex;
            var background = inverted.titleColor.hex;
            if(inverted.iconColor){
                background = inverted.iconColor.hex;
            }
            else if(inverted.taglineColor){
                background = inverted.taglineColor.hex;
            }
            if(inverted.name === 'logo-icon-frame-inverted'){
                inverted.titleColor.hex = background;
                inverted.taglineColor.hex = background;
                inverted.backgroundColor.hex = background;
                inverted.iconColor.hex = foreground;
            }
            else if(inverted.name == 'logo-color'){
                inverted.color1.hex = foreground;
                inverted.color2.hex = foreground;
                inverted.color3.hex = foreground;
                inverted.color4.hex = foreground;
                inverted.taglineColor.hex = foreground;
                inverted.backgroundColor.hex = background;
            }
            else{
                inverted.titleColor.hex = foreground;
                inverted.taglineColor.hex = foreground;
                inverted.backgroundColor.hex = background;
                if(inverted.hasOwnProperty('iconColor')){
                    inverted.iconColor.hex = foreground;
                }
                if(inverted.hasOwnProperty('letterColor')){
                    inverted.letterColor.hex = foreground;
                }
            }

            return inverted;
        },
        gray_logo: function(){
            var gray = JSON.parse(JSON.stringify(this.active_logo));
            var foreground = '#555555';
            var background = '#eeeeee';
            if(gray.name === 'logo-icon-frame-inverted'){
                gray.titleColor.hex = background;
                gray.taglineColor.hex = background;
                gray.backgroundColor.hex = background;
                gray.iconColor.hex = foreground;
            }
            else{
                gray.titleColor.hex = foreground;
                gray.taglineColor.hex = foreground;
                gray.backgroundColor.hex = background;
                if(gray.hasOwnProperty('iconColor')){
                    gray.iconColor.hex = foreground;
                }
                if(gray.hasOwnProperty('letterColor')){
                    gray.letterColor.hex = foreground;
                }
            }

            return gray;
        },
        light_gray_logo: function(){
            var gray = JSON.parse(JSON.stringify(this.active_logo));
            var foreground = '#cccccc';
            var background = '#333333';
            if(gray.name === 'logo-icon-frame-inverted'){
                gray.titleColor.hex = background;
                gray.taglineColor.hex = background;
                gray.backgroundColor.hex = background;
                gray.iconColor.hex = foreground;
            }
            else{
                gray.titleColor.hex = foreground;
                gray.taglineColor.hex = foreground;
                gray.backgroundColor.hex = background;
                if(gray.hasOwnProperty('iconColor')){
                    gray.iconColor.hex = foreground;
                }
                if(gray.hasOwnProperty('letterColor')){
                    gray.letterColor.hex = foreground;
                }
            }

            return gray;
        },
        inverted_color: function(){
            var l = this.active_logo;
            if(l.name === 'logo-icon-frame-inverted'){
                return { titleColor: l.iconColor.hex, taglineColor: l.iconColor.hex, iconColor: l.titleColor.hex, backgroundColor: l.iconColor.hex, letterColor: ''};
            }
            else{
                return { titleColor: l.backgroundColor.hex, taglineColor: l.backgroundColor.hex, iconColor: l.backgroundColor.hex, backgroundColor: l.titleColor.hex, letterColor: l.backgroundColor.hex};
            }
        },
        blackwhite_color: function(){
            if(this.active_logo.name === 'logo-icon-frame-inverted'){
                return { titleColor: '#fff', taglineColor: '#fff',iconColor: '#000', backgroundColor: '#fff', letterColor: '#000'};
            }
            else{
                return { titleColor: '#000', taglineColor: '#000',iconColor: '#000', backgroundColor: '#fff', letterColor: '#000'};
            }
        },
        active_colors: function(){
            if(this.colors[this.active_hue] && this.colors[this.active_hue].length > 0){
                return this.colors[this.active_hue];
            }

            return false;
        },
        nthCharOptions: function(){
            var options = {
                height: 2,
                dotSize: 12,
                min: 0,
                interval: 1,
                tooltip: false,
                piecewise: true,
                bgStyle: {
                    background: '#7c8a95'
                },
                sliderStyle: {
                    background: '#F4C341'
                },
                processStyle: {
                    background: 'transparent'
                }
            }
            var input = this.logos[this.logo_index].title;
            var words = input.match(/\S+/g);

            var num = 0;

            var blacklist = [127];
            for(var i=0; i<words.length; i++){
                for(var j=0; j<words[i].length; j++){
                    var code = words[i].charCodeAt(j);
                    if(code < 33 || blacklist.includes(code)){
                        continue;
                    }
                    num++;
                }
            }
            options.max = num-1;
            return options;
        },
        nthOptions: function(){
            var options = this.nthCharOptions;
            options.max = options.max+1;
            return options;
        }
    },
    methods: {
        reset_page: function(){
            this.logos = [];
            this.logo_index = 0;
            this.page = 'info';
            if(this.loading_logos && this.loading_request){
                this.loading_request.abort();
            }
        },
        arrow_handler: function(direction){
            if(this.page === 'logos'){
                var new_index = this.logo_index + direction;
                if(new_index >= this.logos.length){
                    return false;
                }
                if(new_index < 0){
                    return false;
                }
                this.logo_index = new_index;

                if(!this.loading_logos && this.logo_index >= this.logos.length-9){
                    this.load_logos();

                    mixpanel.track("Load logos", {'user_id': (this.auth0_profile ? this.auth0_profile.user_id : '')});
                }
            }
            else if(this.page === 'color'){
                if(direction > 0 && this.selected_color_styles.length >= 1){
                    this.page = 'logos';
                    this.load_logos(8000);
                    this.animate(8000);
                    mixpanel.track("Generate logos", {
                        "name": this.company_name,
                        "tagline" : this.tagline,
                        "keywords": this.keywords,
                        'user_id': (this.auth0_profile ? this.auth0_profile.user_id : '')
                    });
                }
                else if(direction < 0){
                    this.page = 'keywords';
                }
            }
            else if(this.page === 'keywords'){
                if(direction > 0 && this.keywords.length >= 1){
                    this.page = 'color';
                    mixpanel.track("Color page", {'keywords': this.keywords, 'title': this.company_name, 'tagline': this.tagline,'user_id': (this.auth0_profile ? this.auth0_profile.user_id : '')});
                }
                else if(direction < 0){
                    this.page = 'info';
                }
            }
            else if(this.page === 'info' && direction > 0 && this.company_name.length > 1){
                this.page = 'keywords';
                mixpanel.track("Keyword page", {'keywords': this.keywords, 'title': this.company_name, 'tagline': this.tagline,'user_id': (this.auth0_profile ? this.auth0_profile.user_id : '')});
            }

            return false;
        },
        animate: function(duration){
            var steps = [];
            for(var i=0; i<50; i++){
                steps.push(Math.floor(Math.random()*100));
            }

            steps.sort();
            for(i=1; i<steps.length; i++){
                window.setTimeout(this.animateTo.bind(this, steps[i]), duration*steps[i]/100);
            }
            this.animateTo(0, steps[0]);
        },
        toggle_color_style: function(style){
            var i = this.selected_color_styles.indexOf(style);
            if(i > -1){
                this.selected_color_styles.splice(i,1);
            }
            else{
                this.selected_color_styles.push(style);
            }
        },
        animateTo: function(percent){
            $('#loading_percent').text(percent+'%');
        },
        set_logo_style: function(newstyle){
            if(this.logo_style == newstyle){
                return false;
            }
            else{
                mixpanel.track("Set style", {"style": newstyle, 'user_id': (this.auth0_profile ? this.auth0_profile.user_id : '')});
                this.logo_style = newstyle;
                this.logos = [];
                window.post_cache = {};
                this.logo_index = 0;
                if(this.loading_logos && this.loading_request){
                    this.loading_request.abort();
                }
                this.loading_logos = false;
                this.load_logos(3000);
                this.animate(3000);
            }
        },
        set_hue: function(newhue){
            if(this.active_hue === newhue){
                return false;
            }

            this.active_hue = newhue;
            if(!this.active_colors){
                this.load_colors();
            }
        },
        set_color: function(color){
            if(!color || color.length < 3){
                return false;
            }

            var logo = this.active_logo;
            logo.palette = color;

            if(logo.name === 'logo-icon-frame-inverted'){
                logo.iconColor = {hex: color[0]};
                logo.titleColor = {hex: color[2]};
                logo.taglineColor = {hex: color[2]};
                logo.backgroundColor = {hex: color[2]};
            }
            else if(logo.name === 'logo-color'){
                logo.backgroundColor = {hex: color[2]};
                logo.taglineColor = {hex: color[0]};

                var cs = tinycolor(color[0]).toRgb();
                var ce = tinycolor(color[1]).toRgb();

                var c2 = {r: 0.65*cs.r + 0.35*ce.r, g: 0.65*cs.g + 0.35*ce.g, b: 0.65*cs.b + 0.35*ce.b};
                var c3 = {r: 0.35*cs.r + 0.65*ce.r, g: 0.35*cs.g + 0.65*ce.g, b: 0.35*cs.b + 0.65*ce.b};

                logo.color1 = {hex: color[0]}
                logo.color2 = {hex: tinycolor(c2).toHexString()}
                logo.color3 = {hex: tinycolor(c3).toHexString()}
                logo.color4 = {hex: color[1]}
            }
            else{
                if(logo.hasOwnProperty('titleColor')){
                    logo.titleColor = {hex: color[0]};
                }
                if(logo.hasOwnProperty('taglineColor')){
                    logo.taglineColor = {hex: color[0]};
                }
                if(logo.hasOwnProperty('iconColor')){
                    logo.iconColor = {hex: color[0]};
                }
                if(logo.hasOwnProperty('letterColor')){
                    logo.letterColor = {hex: color[0]};
                }
                if(logo.hasOwnProperty('backgroundColor')){
                    logo.backgroundColor = {hex: color[2]};
                }
            }
        },
        restore_color: function(){
            if(!this.temp_color){
                return false;
            }

            var logo = this.active_logo;
            logo.palette = this.temp_color.palette;

            if(logo.hasOwnProperty('titleColor')){
                logo.titleColor = {hex: this.temp_color.titleColor};
            }
            if(logo.hasOwnProperty('taglineColor')){
                logo.taglineColor = {hex: this.temp_color.taglineColor};
            }
            if(logo.hasOwnProperty('iconColor')){
                logo.iconColor = {hex: this.temp_color.iconColor};
            }
            if(logo.hasOwnProperty('letterColor')){
                logo.letterColor = {hex: this.temp_color.letterColor};
            }
            if(logo.hasOwnProperty('backgroundColor')){
                logo.backgroundColor = {hex: this.temp_color.backgroundColor};
            }
            if(logo.hasOwnProperty('color1')){
                logo.color1 = {hex: this.temp_color.color1};
            }
            if(logo.hasOwnProperty('color2')){
                logo.color2 = {hex: this.temp_color.color2};
            }
            if(logo.hasOwnProperty('color3')){
                logo.color3 = {hex: this.temp_color.color3};
            }
            if(logo.hasOwnProperty('color4')){
                logo.color4 = {hex: this.temp_color.color4};
            }
        },
        refresh_colors: function(){
            this.colors[this.active_hue] = [];
            this.load_colors();
        },
        load_colors: function(){
            if(this.loading_colors){
                return false;
            }

            this.loading_colors = true;
            var data = { hue: this.active_hue };
            $.post('color.php', data, function(result){
                if(!result || !result.length){
                    return false;
                }
                this.colors[this.active_hue] = result;
                this.loading_colors = false;
            }.bind(this), 'json');
        },
        load_logos: function(delay){
            this.loading_logos = true;
            var data = {
                company_name: this.company_name,
                tagline: this.tagline,
                keywords: this.keywords,
                style: this.logo_style,
                color_styles: this.selected_color_styles
            };

            var self = this;
            var starttime = _now();

            this.loading_request = $.ajax({
                url : 'load_random.php',
                type : 'POST',
                data :  data,
                dataType: 'json',
                tryCount : 0,
                retryLimit : 3,
                success : function(result) {
                    var endtime = _now();
                    if(delay && endtime-starttime < delay){
                        window.setTimeout(function(result){
                            this.process_logos(result, self);
                            this.loading_logos = false;

                            /*if(!self.auth0_profile && !self.nagged){
                                self.nagged = true;
                                self.auth0_open();
                                mixpanel.track("Nag login start");
                            }*/
                        }.bind(this, result, self), delay-(endtime-starttime));
                    }
                    else{
                        this.process_logos(result);
                        this.loading_logos = false;

                        /*if(!self.auth0_profile && !self.nagged){
                            self.nagged = true;
                            self.auth0_open();
                            mixpanel.track("Nag login start");
                        }*/
                    }


                }.bind(this),
                error : function(xhr, textStatus, errorThrown ) {
                    if(textStatus === 'abort'){
                        return false;
                    }

                    this.tryCount++;
                    if (this.tryCount <= this.retryLimit) {
                        //try again
                        $.ajax(this);
                        mixpanel.track("Load Error", {'retry': this.tryCount, 'status': textStatus, 'error': errorThrown, 'msg': xhr.responseJSON});
                        return;
                    }
                    else{
                        self.loading_logos = false;
                        mixpanel.track("Load Error", {'retry': -1, 'status': textStatus, 'error': errorThrown, 'msg': xhr.responseJSON});
                    }
                },
                timeout: 60000
            });
        },
        process_logos: function(loaded){
            for(var i=0; i<loaded.length; i++){
                this.logos.push(loaded[i]);
            }
        },
        save: function(){
            var logo = this.logos[this.logo_index];

            if(this.saved_logos.includes(logo)){
                var index = this.saved_logos.indexOf(logo);

                if (index !== -1) {
                    this.saved_logos.splice(index, 1);
                }
            }
            else{
                this.saved_logos.push(logo);
            };

            var copy = JSON.parse(JSON.stringify(logo));
            copy.user_id = this.auth0_profile ? this.auth0_profile.user_id : '';
            mixpanel.track("Save logo", copy);

            if(!this.auth0_profile && !this.nagged){
                this.nagged = true;
                this.auth0_open();
                mixpanel.track("Nag login");
            }
            /*if(!this.profile && !this.nagged){
                this.nagged = true;
                setTimeout(this.auth0_open, 2000);
                mixpanel.track("Nag login");
            }*/
        },
        is_saved: function(logo){
            return this.saved_logos.includes(logo);
        },
        load_saved: function(logo){
            var index = this.logos.indexOf(logo);

            if (index !== -1) {
                this.logos.splice(index, 1);
            }
            this.logos.splice(this.logo_index, 0, logo);
        },
        set_variant: function(logo){
            this.logos.splice(this.logo_index, 1);
            this.logos.splice(this.logo_index, 0, logo);
            this.variant_mode = false;
        },
        remove_saved: function(logo){
            var index = this.saved_logos.indexOf(logo);

            if (index !== -1) {
                this.saved_logos.splice(index, 1);
            }
        },
        edit_show_section: function(id, event){
            $('#edit_page .button').removeClass('active');

            if(event && event.target){
                var target = $(event.target);
                if(!target.hasClass('button')){
                    target = target.parent();
                }
                if(target.hasClass('button')){
                    target.addClass('active');
                }
            }
            $('.edit-section:visible').slideUp();
            $('#'+id).slideDown();

            this.$nextTick(function (){
                if (Event.prototype.initEvent) {
                    var evt = window.document.createEvent('UIEvents');
                    evt.initUIEvent('resize', true, false, window, 0);
                    window.dispatchEvent(evt);
                }
                else{
                    window.dispatchEvent(new Event('resize'));
                }
            })
        },
        edit_close: function(){
            this.clear_color();
            this.edit_mode = false;
        },
        edit_open: function(){
            this.edit_mode = true;
            // triggers re-draw of sliders
            // todo: fix this
            this.$nextTick(function (){
                if (Event.prototype.initEvent) {
                    var evt = window.document.createEvent('UIEvents');
                    evt.initUIEvent('resize', true, false, window, 0);
                    window.dispatchEvent(evt);
                }
                else{
                    window.dispatchEvent(new Event('resize'));
                }
            })

            // load colors
            if(!this.active_colors){
                this.load_colors();
            }

            this.set_temp_color(false);

            var copy = JSON.parse(JSON.stringify(this.active_logo));
            copy.user_id = this.auth0_profile ? this.auth0_profile.user_id : '';
            mixpanel.track("Edit open", copy);
        },
        preview_open: function(){
            this.preview_mode = true;
            window.scrollTo(0, 0);
            var copy = JSON.parse(JSON.stringify(this.active_logo));
            copy.user_id = this.auth0_profile ? this.auth0_profile.user_id : '';
            mixpanel.track("Preview open", copy);
        },
        purchase_open: function(){
            this.purchase_mode = true;
            window.scrollTo(0, 0);
            var copy = JSON.parse(JSON.stringify(this.active_logo));
            copy.user_id = this.auth0_profile ? this.auth0_profile.user_id : '';
            mixpanel.track("Purchase open", copy);
        },
        variant_open: function(){
            if(!this.variant_mode){
                window.scrollTo(0, 0);
                this.variant_logos = [];
            }

            this.variant_mode = true;
            this.variant_loading = true;


            var self = this;
            $.ajax({
                url : 'variant_font.php',
                type : 'POST',
                data :  {data: this.active_logo, font: this.font_config, num: this.variant_logos.length},
                dataType: 'json',
                tryCount : 0,
                retryLimit : 3,
                success : function(result) {
                    this.variant_loading = false;

                    if(result.length == 12){
                        if(this.variant_logos.length > 0){
                            this.variant_logos = this.variant_logos.concat(result);
                        }
                        else{
                            this.variant_logos = result;
                        }
                    }
                }.bind(this),
                error : function(xhr, textStatus, errorThrown ) {
                    this.tryCount++;
                    if (this.tryCount <= this.retryLimit) {
                        //try again
                        $.ajax(this);
                        mixpanel.track("Variant Error", {'retry': this.tryCount});
                        return;
                    }
                    else{
                        self.variant_loading = false;
                        mixpanel.track("Variant Error", {'retry': -1});
                    }
                },
                timeout: 30000
            });

            var copy = JSON.parse(JSON.stringify(this.active_logo));
            copy.user_id = this.auth0_profile ? this.auth0_profile.user_id : '';
            mixpanel.track("Variant open", copy);
        },
        share_open: function(){
            this.share_mode = true;
            this.share_url = this.get_url();

            var copy = JSON.parse(JSON.stringify(this.active_logo));
            copy.user_id = this.auth0_profile ? this.auth0_profile.user_id : '';
            mixpanel.track("Share open", copy);
        },
        share_copy: function(){
            $('#share_url').select();
            document.execCommand("copy");
            $('#share_copy span').text('Copied!');
            setTimeout(function(){
                $('#share_copy span').text('Click to copy link');
            },5000);

            mixpanel.track("Share copy");
        },
        set_temp_color: function(hex){
            this.temp_color = {
                palette: this.active_logo.palette,
                rgb: hex,
                titleColor: (this.active_logo.hasOwnProperty('titleColor') ? this.active_logo.titleColor.hex : false),
                taglineColor: (this.active_logo.hasOwnProperty('taglineColor') ? this.active_logo.taglineColor.hex : false),
                iconColor: (this.active_logo.hasOwnProperty('iconColor') ? this.active_logo.iconColor.hex : false),
                letterColor: (this.active_logo.hasOwnProperty('letterColor') ? this.active_logo.letterColor.hex : false),
                backgroundColor: (this.active_logo.hasOwnProperty('backgroundColor') ? this.active_logo.backgroundColor.hex : false),
                color1: (this.active_logo.hasOwnProperty('color1') ? this.active_logo.color1.hex : false),
                color2: (this.active_logo.hasOwnProperty('color2') ? this.active_logo.color2.hex : false),
                color3: (this.active_logo.hasOwnProperty('color3') ? this.active_logo.color3.hex : false),
                color4: (this.active_logo.hasOwnProperty('color4') ? this.active_logo.color4.hex : false)
            };
        },
        clear_color: function(e){
            if(e && e.target && $(e.target).parents('.vc-chrome').get(0)){
                return false;
            }
            this.title_color_show = false;
            this.tagline_color_show = false;
            this.nth1_color_show = false;
            this.nth2_color_show = false;
            this.nth3_color_show = false;
            this.nth4_color_show = false;
            this.icon_color_show = false;
            this.letter_color_show = false;
            this.background_color_show = false;
        },
        auto_scale: function(index, factor, taglinefactor, iconfactor){
            this.logos[index].autoScale = false;
            this.logos[index].titleScale *= factor;

            if(taglinefactor){
                this.logos[index].taglineScale *= taglinefactor;
            }
            else{
                this.logos[index].taglineScale *= factor;
            }

            if(iconfactor){
                this.logos[index].iconScale *= iconfactor;
            }
        },
        auto_scale_variant: function(index, factor, taglinefactor, iconfactor){
            this.variant_logos[index].autoScale = false;
            this.variant_logos[index].titleScale *= factor;

            if(taglinefactor){
                this.variant_logos[index].taglineScale *= taglinefactor;
            }
            else{
                this.variant_logos[index].taglineScale *= factor;
            }

            if(iconfactor){
                this.variant_logos[index].iconScale *= iconfactor;
            }
        },
        icon_open: function(){
            window.scrollTo(0, 0);
            this.icon_mode = true;
            this.icon_search_term = '';
            this.icon_search();
        },
        icon_search: function(){
            this.icon_loading = true;
            var self = this;
            $.ajax({
                url : './icons.php',
                type : 'POST',
                data :  {id: this.active_logo.iconId, term: this.icon_search_term, num: this.icons.length},
                dataType: 'json',
                tryCount : 0,
                retryLimit : 3,
                success : function(result) {
                    if(result && result.length > 0){
                        this.icons = this.icons.concat(result);
                    }
                    this.icon_loading = false;
                }.bind(this),
                error : function(xhr, textStatus, errorThrown ) {
                    if(textStatus === 'abort'){
                        return false;
                    }
                    this.tryCount++;
                    if (this.tryCount <= this.retryLimit) {
                        //try again
                        mixpanel.track("Icon Load Error", {'retry': this.tryCount, 'status': textStatus, 'error': errorThrown, 'msg': xhr.responseJSON});

                        $.ajax(this);
                        return;
                    }
                    self.icon_loading = false;
                    mixpanel.track("Icon Load Error", {'retry': -1, 'status': textStatus, 'error': errorThrown, 'msg': xhr.responseJSON});
                },
                timeout: 30000
            });
        },
        icon_set: function(iconid){
            this.active_logo.iconId = iconid;
            this.icon_mode = false;
        },
        get_url: function(){
            var data = JSON.parse(JSON.stringify(this.active_logo));
            for (var key in data) {
                if(data && data.hasOwnProperty(key)) {
                    if(data[key] && data[key].hasOwnProperty('hex')){
                        data[key] = {hex: data[key].hex}; // remove hsl/rgba values
                    }
                }
            }

            data.keywords = this.keywords;
            data.color_styles = this.selected_color_styles;

            var params = $.param(data);
            return 'https://app.brandmark.io/v2/?'+params;
        },
        purchase: function(tier){
            this.purchase_tier = tier;

            var tiers = {
                'basic' : {
                    amount: 2500,
                    description: 'Basic Package'
                },
                'designer' : {
                    amount: 6500,
                    description: 'Designer Package'
                },
                'enterprise' : {
                    amount: 17500,
                    description: 'Enterprise Package'
                }
            };

            mixpanel.track("Stripe open", {'tier': tier, 'user_id': (this.auth0_profile ? this.auth0_profile.user_id : '')});

            tier = tiers[tier];

            stripe_handler.open({
                name: 'Brandmark',
                description: tier.description,
                zipCode: false,
                amount: tier.amount,
                currency: 'usd',
                allowRememberMe: true
            });

        },
        auth0_open: function(){
            if(this.auth0_profile){
                return false;
            }
            mixpanel.track("Login open");
            this.auth0_mode = true;
            this.$nextTick(function (){
                window.lock.show({
                    initialScreen: 'signUp',
                    languageDictionary: {
                        title: "Sign up to save your work",
                        signupTitle: "Sign up to save your work"
                    },
                    theme: {
                        logo: 'https://app.brandmark.io/v2/img/logo.png',
                        primaryColor: '#6ECCDF'
                    }

                });
            });
        }
    },
    components: {
        'logo-vertical': logo_vertical,
        'logo-vertical-icon': logo_vertical_icon,
        'logo-horizontal-icon': logo_horizontal_icon,
        'logo-icon-replacement': logo_icon_replacement,
        'logo-icon-frame': logo_icon_frame,
        'logo-icon-frame-inverted': logo_icon_frame_inverted,
        'logo-letter': logo_letter,
        'logo-color': logo_color,
        'input-tag': input_tag,
        'input-slider': input_slider,
        'input-color': VueColor.Chrome
    }
})

var query = window.location.search.substring(1);
if(query){
    var logo = $.deparam(query);

    if(logo.hasOwnProperty('name')){
        for (var k in logo) {
            if (logo.hasOwnProperty(k)) {
                if(logo[k] === 'true'){
                    logo[k] = true;
                }
                else if(logo[k] === 'false'){
                    logo[k] = false;
                }
                else if(logo[k] && !isNaN(logo[k])){
                    logo[k] = parseFloat(logo[k]);
                }
            }
        }

        logo.title = String(logo.title);
        logo.tagline = String(logo.tagline);

        brandmark.company_name = logo.title;
        brandmark.tagline = logo.tagline;
        if(logo.keywords){
            if(logo.keywords instanceof Array){
                brandmark.keywords = logo.keywords.slice();
            }
            else{
                brandmark.keywords = [logo.keywords];
            }
        }
        else{
            brandmark.keywords = ['abstract'];
        }
        var c = logo.color_styles;
        if(c && c.length > 0){
            brandmark.selected_color_styles = c.slice();
        }
        brandmark.logos.push(logo);

        brandmark.page = 'logos';
        brandmark.load_logos();

        if(window.referral){
            logo.referral = window.referral;
        }
        mixpanel.track("Page load shared", logo);
    }
}
else{
    var referral = Cookies.get('referral');
    mixpanel.track("Page load", { referral: (referral ? referral : '') });
}

WebFont.load({
    google: {
        families: [
            "Montserrat:100,200,300,400,700,900",
            "Lora:italic"
        ]
    },
    timeout: 15000
});

window.preload_images = [];

function preload(images) {
    for (i = 0; i < images.length; i++) {
        window.preload_images[i] = new Image();
        window.preload_images[i].src = images[i];
    }
}
// no need to preload immediately visible images
preload([
    'img/close.svg',
    'img/close_large_blue.svg',
    'img/close_white.svg'
]);

function load_saved(){
    if(!window.brandmark || !window.brandmark.auth0_access_token){
        return false;
    }
    $.ajax({
        url : './auth/',
        type : 'POST',
        data :  {action: 'load',access_token: window.brandmark.auth0_access_token},
        dataType: 'json',
        tryCount : 0,
        retryLimit : 3,
        success : function(result) {
            if(result && result.length > 0){
                for(var i=0; i<result.length; i++){
                    var dupe = false;
                    var istring = JSON.stringify(result[i]);
                    for(var j=0; j<window.brandmark.saved_logos.length; j++){
                        if(JSON.stringify(window.brandmark.saved_logos[j]) == istring){
                            dupe = true;
                        }
                    }
                    if(!dupe){
                        window.brandmark.saved_logos.push(result[i]);
                    }
                }
            }
        },
        error : function(xhr, textStatus, errorThrown ) {
            if(textStatus === 'abort'){
                return false;
            }
            this.tryCount++;
            if (this.tryCount <= this.retryLimit) {
                //try again
                mixpanel.track("Auth Load Error", {'retry': this.tryCount, 'status': textStatus, 'error': errorThrown, 'msg': xhr.responseJSON});

                $.ajax(this);
                return;
            }
            mixpanel.track("Auth Load Error", {'retry': -1, 'status': textStatus, 'error': errorThrown, 'msg': xhr.responseJSON});
        },
        timeout: 30000
    });
}

function save_logos(svg, logos, token){
    $.ajax({
        url : './auth/',
        type : 'POST',
        data :  {
            action: 'save',
            access_token: token,
            logos: JSON.stringify(logos),
            svg: svg
        },
        dataType: 'text',
        tryCount : 0,
        retryLimit : 3,
        success : function(result) {
            if(result !== 'success'){
                this.tryCount++;
                if (this.tryCount <= this.retryLimit) {
                    //try again
                    mixpanel.track("Auth Save Error", {'retry': this.tryCount, 'status': textStatus, 'error': errorThrown, 'msg': xhr.responseJSON});

                    $.ajax(this);
                    return;
                }
            }
        },
        error : function(xhr, textStatus, errorThrown ) {
            if(textStatus === 'abort'){
                return false;
            }
            this.tryCount++;
            if (this.tryCount <= this.retryLimit) {
                //try again
                mixpanel.track("Auth Save Error", {'retry': this.tryCount, 'status': textStatus, 'error': errorThrown, 'msg': xhr.responseJSON});

                $.ajax(this);
                return;
            }
            mixpanel.track("Auth Save Error", {'retry': -1, 'status': textStatus, 'error': errorThrown, 'msg': xhr.responseJSON});
        },
        timeout: 60000
    });
}

// load previously stored info
if(storage){
    var company_name = storage.getItem('company_name');
    if(company_name && company_name !== 'null' && company_name !== 'undefined'){ // todo: fix this
        window.brandmark.company_name = company_name;
    }

    var tagline = storage.getItem('tagline');
    if(tagline && tagline !== 'null' && company_name !== 'undefined'){ // todo: fix this
        window.brandmark.tagline = tagline;
    }

    var keywords = storage.getItem('keywords');
    if(keywords){
        keywords = JSON.parse(keywords);
        if(keywords && keywords.length > 0){
            window.brandmark.keywords = keywords;
        }
    }

    var color_styles = storage.getItem('selected_color_styles');
    if(color_styles){
        color_styles = JSON.parse(color_styles);
        if(color_styles && color_styles.length > 0){
            window.brandmark.selected_color_styles = color_styles;
        }
    }


    // auth0 data
    var access_token = storage.getItem('auth0_access_token');
    var expires = storage.getItem('auth0_expires');
    if(access_token && access_token !== 'null' && access_token !== 'undefined' && expires && expires !== 'null' && expires !== 'undefined'){
        brandmark.auth0_expires = expires;
        //var timestamp = Math.floor(Date.now() / 1000);
        //if(timestamp < expires-1000){
        var access_token = storage.getItem('auth0_access_token');
        if(access_token && access_token !== 'null'){
            brandmark.auth0_access_token = access_token;
        }

        var profile = storage.getItem('auth0_profile');
        if(profile && profile !== 'null'){
            profile = JSON.parse(profile);
            if(profile && profile !== null){
                brandmark.auth0_profile = profile;
                mixpanel.track("Restored session", {'user_id':profile.user_id});

                if(brandmark.company_name && brandmark.keywords && brandmark.keywords.length > 0 && brandmark.selected_color_styles && brandmark.selected_color_styles.length > 0){
                    brandmark.page = 'logos';
                    brandmark.load_logos(3000);
                    brandmark.animate(3000);
                }
            }
        }

        window.load_saved();
        //}
    }
}


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
