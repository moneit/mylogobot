@extends('layouts.page')

@section('title')
    <title>FAQ | Logo Bot</title>
@endsection

@section('meta-description')
    <meta name="description" content="Find the answer to the frequently asked questions." />
@endsection

@section('styles')
    <link rel='stylesheet' href='{{ mix("/css/faq.css") }}'>
    <link rel="stylesheet" href="/css/icomoon/style.css">
@endsection

@section('content')
    <div id='faq-app' class='container content'>

        <h1>FAQ</h1>

        <div class='row mb-3'>
            <div class='col-md-8 offset-md-2'>
                <faq>
                    <template v-slot:quiz>
                        Why use Logo.bot?
                    </template>
                    <template v-slot:answer>
                        Logo.bot offers its customers an innovative interface with a fast-paced process to create the perfect logo for your brand!
                    </template>
                </faq>
                <faq>
                    <template v-slot:quiz>
                        How does it work?
                    </template>
                    <template v-slot:answer>
                        Logo.Bot is an online logo maker which has a conversational UI allowing you to create your own logo easily. You don’t need to have any design skills, chat with our bot and let him do everything for you.
                        <br/>
                        All you have to do is engage in a conversation with our bot about your brand. After your conversation, our bot will give you a lot of choices to pick from. All you need to do is select a logo design, and if you want you can go for quick customization, and then you can download your logo instantly after purchase.
                    </template>
                </faq>
                <faq>
                    <template v-slot:quiz>
                        How do I sign up?
                    </template>
                    <template v-slot:answer>
                        On the top right corner of the page, there’s a sign in button which allows you to sign up.
                        <br/>
                        If you click, it will appear a popup, you can connect with Facebook or sign up using an email address.
                    </template>
                </faq>
                <faq>
                    <template v-slot:quiz>
                        Why isn’t my Facebook account working?
                    </template>
                    <template v-slot:answer>
                        If your Facebook was registered with a telephone number, you may not be able to log in.
                        <br/>
                        However, you can complete your sign up by using your email address.
                    </template>
                </faq>
                <faq>
                    <template v-slot:quiz>
                        I can’t remember my password
                    </template>
                    <template v-slot:answer>
                        Please go to the log in area and reset your password. Check your spam folder for the reset password email.
                    </template>
                </faq>
                <faq>
                    <template v-slot:quiz>
                        Can I download my logo for free?
                    </template>
                    <template v-slot:answer>
                        Currently, we have one plan which allows downloading their logo for free.
                    </template>
                </faq>
                <faq>
                    <template v-slot:quiz>
                        What type of files do I get when downloading?
                    </template>
                    <template v-slot:answer>
                        We offer 3 different packages that include different file formats and sizes. You can learn more about them on our pricing page.
                    </template>
                </faq>
                <faq>
                    <template v-slot:quiz>
                        How can I get my logo with a transparent background?
                    </template>
                    <template v-slot:answer>
                        You can get files with a transparent background by purchasing any of the packages.
                        <br/>
                        <em>Notice:</em> Free package doesn’t come with a transparent background
                    </template>
                </faq>
                <faq>
                    <template v-slot:quiz>
                        What benefits do I get from purchasing a package?
                    </template>
                    <template v-slot:answer>
                        You get tons of benefits when purchasing, for technical details check our pricing page. Besides that, we’ll assure you get the best support.
                    </template>
                </faq>
                <faq>
                    <template v-slot:quiz>
                        Can I download after I purchased?
                    </template>
                    <template v-slot:answer>
                        You’re able to download your logo design immediately after purchasing.
                    </template>
                </faq>
                <faq>
                    <template v-slot:quiz>
                        When I buy a logo is there any form of subscription?
                    </template>
                    <template v-slot:answer>
                        No, all our plans are a single one-time payment.
                        <br/>
                        However, we plan to offer monthly subscription packages in the future.
                    </template>
                </faq>
                <faq>
                    <template v-slot:quiz>
                        Can I save my logo design so I can purchase it later?
                    </template>
                    <template v-slot:answer>
                        Yes, currently you can save some of your favourite designs then go back and purchase them.
                    </template>
                </faq>
                <faq>
                    <template v-slot:quiz>
                        I made a mistake in the logo that I purchased earlier.
                    </template>
                    <template v-slot:answer>
                        Please let us know through live chat or contact form so we can work it out together.
                    </template>
                </faq>
                <faq>
                    <template v-slot:quiz>
                        Can I copyright my logo?
                    </template>
                    <template v-slot:answer>
                        You’re free to register a trademark of your logo. Please be informed as to what you need for that process since it varies from country to country.
                    </template>
                </faq>
                <faq>
                    <template v-slot:quiz>
                        Where is my payment receipt?
                    </template>
                    <template v-slot:answer>
                        After you purchase your logo, we send you a receipt by email. Please check your mail to make sure you received your receipt.
                    </template>
                </faq>
                <faq>
                    <template v-slot:quiz>
                        Can I request a refund?
                    </template>
                    <template v-slot:answer>
                        We offer you a 7-day refund policy where you have until 7 days to contact us in case you need to request a refund.
                    </template>
                </faq>
            </div>
        </div>
    </div>
@endsection

@section('page-scripts')
    <script src='{{ mix("/js/faq.js") }}'></script>
@endsection