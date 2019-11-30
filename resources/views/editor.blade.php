@extends('layouts.page')

@section('title')
    <title>Editor | Logo Bot</title>
@endsection

@section('meta-description')
    <meta name="description" content="Edit your logo and download when you're happy with how it looks." />
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ mix('/css/editor.css') }}">
    <link rel="stylesheet" href="/css/icomoon/style.css">
@endsection

@section('page')
    <div id="app">
        <input type="checkbox" id="back-link" class="back-link" v-model="backLink"/>

        <nav class="d-none d-md-flex navbar navbar-top">
            <div class="container-fluid">
                <div>
                    <label class="back-link" for="back-link">
                        <i class="logobot-icon icon-angle-left"></i>
                    </label>

                    <a class="navbar-brand mr-0 mr-md-2" href="/" aria-label="myLogoBot">
                        <img src="/img/logo_reversed.svg" class="logo" alt="LogoBot"/>
                    </a>
                </div>

                <div class="navbar-expand">
                    <ul class="navbar-nav ml-auto align-items-center">
                        <li class="nav-item">
                            <label class="nav-link btn btn-outline-light px-md-4 px-lg-5 mr-md-3" v-on:click="save" id="btn-save">
                                <i class="logobot-icon icon-heart"></i>
                                <span class="d-none d-md-inline-block">Save</span>
                            </label>
                        </li>
                        <li class="nav-item">
                            <label for="preview-toggle" class="nav-link btn btn-outline-light px-md-4 px-lg-5 mr-md-3" id="btn-preview">
                                <i class="logobot-icon icon-eye"></i>
                                <span class="d-none d-md-inline-block">Preview</span>
                            </label>
                        </li>
                        <li class="nav-item">
                            <label class="nav-link btn px-md-4 px-lg-5 mr-md-3 btn-download" v-on:click="download" id="btn-download">
                                <i class="logobot-icon icon-download"></i>
                                <span>DOWNLOAD</span>
                            </label>
                        </li>
                        @if (\Auth::user()->isAdmin())
                            <li class="nav-item">
                                <label class="nav-link btn btn-outline-light px-md-4 px-lg-5 mr-md-3" v-on:click="openColorCombinationModal">
                                    <span class="d-none d-md-inline-block">Save Color Combination</span>
                                </label>
                            </li>
                            <li class="nav-item">
                                <label class="nav-link btn btn-outline-light px-md-4 px-lg-5 mr-md-3" v-on:click="openFontCombinationModal">
                                    <span class="d-none d-md-inline-block">Save Font Combination</span>
                                </label>
                            </li>
                        @endif
                        <li id="sidebar-collapse" class="nav-item sidebar-collapse">
                            <label for="sidebar-toggle">
                                <i class="logobot-icon icon-hamburger pointer"></i>
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <nav id="mobile-top" class="navbar pt-4 pb-4 d-md-none">
            <div class="container-fluid">
                <div>
                    <label class="back-link" for="back-link">
                        <i class="logobot-icon icon-angle-left"></i>
                    </label>

                    <a class="navbar-brand mr-0 mr-md-2" href="/" aria-label="myLogoBot">
                        <img src="/img/logo_reversed.svg" class="logo" alt="LogoBot"/>
                    </a>
                </div>

                <div class="navbar-expand">
                    <ul class="navbar-nav ml-auto align-items-center">
                        <li id="sidebar-collapse" class="nav-item sidebar-collapse">
                            <label for="sidebar-toggle">
                                <i class="logobot-icon icon-hamburger pointer"></i>
                            </label>
                        </li>
                    </ul>
                </div>

                <div class="navbar-expand d-md-none w-100 pt-2">
                    <ul class="navbar-nav">
                        <li class="nav-item mr-2">
                            <label class="nav-link rounded-circle btn btn-outline-light" v-on:click="save" id="btn-save">
                                <i class="logobot-icon icon-heart"></i>
                            </label>
                        </li>
                        <li class="nav-item">
                            <label for="preview-toggle" class="nav-link rounded-circle btn btn-outline-light" id="btn-preview">
                                <i class="logobot-icon icon-eye"></i>
                            </label>
                        </li>
                        <li class="nav-item ml-auto">
                            <label class="nav-link btn btn-download" v-on:click="download" id="btn-download">
                                <i class="logobot-icon icon-download"></i>
                                <span>DOWNLOAD</span>
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        @include('components.sidebar')

        <div class="container-fluid editor">
            <div class="row">
                <div class="col-md-1">
                    <div class="d-none d-md-flex flex-column justify-content-between text-center desktop-nav">
                        <ul class="nav flex-column" id="tabs" role="tablist">
                            <li class="nav-item" id="tab-name">
                                <a class="nav-link px-0 py-4 active" id="info-tab" href="#name" data-toggle="tab" role="tab" aria-controls="info" aria-selected="true">
                                    <div class="icon"><i class="logobot-icon icon-user-edit"></i></div>
                                    <div>Name</div>
                                </a>
                            </li>
                            <li class="nav-item" id="tab-slogan">
                                <a class="nav-link px-0 py-4" id="logos-tab" href="#slogan" data-toggle="tab" role="tab" aria-controls="logos" aria-selected="false">
                                    <div class="icon"><i class="logobot-icon icon-font"></i></div>
                                    <div>Slogan</div>
                                </a>
                            </li>
                            <li class="nav-item" id="tab-symbol">
                                <a class="nav-link px-0 py-4" id="orders-tab" href="#symbol" data-toggle="tab" role="tab" aria-controls="orders" aria-selected="false">
                                    <div class="icon"><i class="logobot-icon icon-shield"></i></div>
                                    <div>Symbol</div>
                                </a>
                            </li>
                            {{--<li class="nav-item">--}}
                                {{--<a class="nav-link px-0 py-4" id="orders-tab" href="#container" data-toggle="tab" role="tab" aria-controls="orders" aria-selected="false">--}}
                                    {{--<div class="icon"><i class="logobot-icon icon-containers"></i></div>--}}
                                    {{--<div>Container</div>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            <li class="nav-item" id="tab-color">
                                <a class="nav-link px-0 py-4" id="orders-tab" href="#color-scheme" data-toggle="tab" role="tab" aria-controls="orders" aria-selected="false">
                                    <div class="icon"><i class="logobot-icon icon-colorscheme"></i></div>
                                    <div>Color Scheme</div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-9 order-md-last p-30" style="background-color: #E5E5E5;">
                    <div class="row h-100">
                        <div class="panel-wrapper">
                            <div class="row h-100 m-0 d-flex flex-column justify-content-center">
                                <div class="panel-container shadow">
                                    <div class="panel" id="logo-symbol-only" style="visibility: hidden;">
                                        <logo-symbol></logo-symbol>
                                    </div>
                                    <div class="panel" id="logo-editor">
                                        <logo draggable :show-water-mark="true"></logo>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2 editor-control-panel">
                    <div class="tab-content py-3" id="myTabContent">
                        <div class="tab-pane fade show active name-tab" id="name" role="tabpanel" aria-labelledby="name-tab">
                            <div>
                                <div class="d-none d-md-flex">
                                    <logo-input field="text" module="company-name" label="Company Name" class="w-100"></logo-input>
                                </div>
                                <div class="d-flex d-md-none">
                                    <logo-input field="text" module="company-name" label="Company Name" class="w-50"></logo-input>
                                    <text-capitalizer-mobile field="capitalization" module="company-name" class="w-50"></text-capitalizer-mobile>
                                </div>
                                <div class="mb-3">
                                    <slider field="font-size" module="company-name" label="Font Size"></slider>
                                </div>
                                <div class="mb-3">
                                    <slider field="letter-space" module="company-name" label="Letter Space"></slider>
                                </div>
                                <div class="mb-3">
                                    <slider field="line-space" module="company-name" label="Line Space"></slider>
                                </div>
                                <div class="d-flex mb-3">
                                    <font-selector class="flex-fill d-none d-md-block" field="font" module="company-name"></font-selector>
                                    <font-selector-mobile class="flex-fill d-md-none" field="font" module="company-name"></font-selector-mobile>
                                    <color-selector class="ml-3" field="color" module="company-name"></color-selector>
                                </div>
                                <text-capitalizer class="d-none d-md-flex" field="capitalization" module="company-name"></text-capitalizer>
                            </div>
                        </div>
                        <div class="tab-pane fade slogan-tab" id="slogan" role="tabpanel" aria-labelledby="slogan-tab">
                            <div>
                                <div class="d-none d-md-flex">
                                    <logo-input field="text" module="slogan" label="Slogan" class="w-100"></logo-input>
                                </div>
                                <div class="d-flex d-md-none">
                                    <logo-input field="text" module="slogan" label="Slogan" class="w-50"></logo-input>
                                    <text-capitalizer-mobile field="capitalization" module="slogan" class="w-50"></text-capitalizer-mobile>
                                </div>
                                <div class="mb-3">
                                    <slider field="font-size" module="slogan" label="Font Size"></slider>
                                </div>
                                <div class="mb-3">
                                    <slider field="letter-space" module="slogan" label="Letter Space"></slider>
                                </div>
                                <div class="mb-3">
                                    <slider field="line-space" module="slogan" label="Line Space"></slider>
                                </div>
                                <div class="d-flex mb-3">
                                    <font-selector class="flex-fill d-none d-md-block" field="font" module="slogan"></font-selector>
                                    <font-selector-mobile class="flex-fill d-md-none" field="font" module="slogan"></font-selector-mobile>
                                    <color-selector class="ml-3" field="color" module="slogan"></color-selector>
                                </div>
                                <text-capitalizer class="d-none d-md-flex" field="capitalization" module="slogan"></text-capitalizer>
                            </div>
                        </div>
                        <div class="tab-pane fade symbol-tab" id="symbol" role="tabpanel" aria-labelledby="symbol-tab">
                            <type-selector module="symbol">
                                <div class="icon-tab-content" slot="Icon">
                                    <div class="mb-3">
                                        <slider field="icon-size" module="symbol" label="Symbol Size"></slider>
                                    </div>
                                    <div class="mb-3">
                                        <slider field="line-space" module="symbol" label="Line Space"></slider>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <icon-selector class="flex-fill" field="icon" module="symbol"></icon-selector>
                                        <color-selector class="ml-3" field="color" module="symbol"></color-selector>
                                    </div>
                                    <div class="mb-3">
                                        <remove-icon-switch></remove-icon-switch>
                                    </div>
                                </div>
                                <div class="initials-tab-content" slot="Initials">
                                    <div class="d-flex">
                                        <logo-input field="text" module="symbol" label="Initials" class="w-100"></logo-input>
                                    </div>
                                    <div class="mb-3">
                                        <slider field="font-size" module="symbol" label="Symbol Size"></slider>
                                    </div>
                                    <div class="mb-3">
                                        <slider field="line-space" module="symbol" label="Line Space"></slider>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <font-selector class="flex-fill" field="font" module="symbol"></font-selector>
                                        <color-selector class="ml-3" field="color" module="symbol"></color-selector>
                                    </div>
                                </div>
                            </type-selector>
                        </div>
                        <div class="tab-pane fade container-tab" id="container" role="tabpanel" aria-labelledby="container-tab">
                            <type-selector module="container">
                                <div class="filled-tab-content" slot="Filled">
                                    <div class="mb-3 w-100">
                                        <slider field="size" module="container" label="Container Size"></slider>
                                    </div>
                                    <div class="mb-3 w-100">
                                        <color-selector field="color" module="container"></color-selector>
                                    </div>
                                    <div class="w-100 square-box-container">
                                        <div class="square-box">
                                            <container-selector field="selected" module="container"></container-selector>
                                        </div>
                                    </div>
                                </div>
                                <div class="outlined-tab-content" slot="Outlined">
                                    <div class="mb-3 w-100">
                                        <slider field="size" module="container" label="Container Size"></slider>
                                    </div>
                                    <div class="mb-3 w-100">
                                        <color-selector field="color" module="container"></color-selector>
                                    </div>
                                    <div class="w-100 square-box-container">
                                        <div class="square-box">
                                            <container-selector field="selected" module="container"></container-selector>
                                        </div>
                                    </div>
                                </div>
                            </type-selector>
                        </div>
                        <div class="tab-pane fade color-scheme-tab" id="color-scheme" role="tabpanel" aria-labelledby="color-scheme-tab">
                            <palette-selector></palette-selector>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <nav id="mobile-top-fixed" class="navbar pt-4 pb-4 d-md-none">
            <div class="container-fluid">
                <div class="navbar-expand d-md-none w-100 pt-2">
                    <ul class="navbar-nav">
                        <li class="nav-item mr-2">
                            <label class="nav-link rounded-circle btn btn-outline-light" v-on:click="save" id="btn-save">
                                <i class="logobot-icon icon-heart"></i>
                            </label>
                        </li>
                        <li class="nav-item">
                            <label for="preview-toggle" class="nav-link rounded-circle btn btn-outline-light" id="btn-preview">
                                <i class="logobot-icon icon-eye"></i>
                            </label>
                        </li>
                        <li class="nav-item ml-auto">
                            <label class="nav-link btn btn-download" v-on:click="download" id="btn-download">
                                <i class="logobot-icon icon-download"></i>
                                <span>DOWNLOAD</span>
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <nav class="d-md-none navbar fixed-bottom text-center mobile-nav p-0" style="font-size: 0.75rem;">
            <ul class="nav justify-content-between w-100" id="tabs" role="tablist">
                <li class="nav-item" id="tab-name">
                    <a class="nav-link px-0 h-100 d-flex flex-column justify-content-center active" id="info-tab" href="#name" data-toggle="tab" role="tab" aria-controls="info" aria-selected="true">
                        <div class="icon"><i class="logobot-icon icon-user-edit"></i></div>
                        <div>Name</div>
                    </a>
                </li>
                <li class="nav-item" id="tab-slogan">
                    <a class="nav-link px-0 h-100 d-flex flex-column justify-content-center" id="logos-tab" href="#slogan" data-toggle="tab" role="tab" aria-controls="logos" aria-selected="false">
                        <div class="icon"><i class="logobot-icon icon-font"></i></div>
                        <div>Slogan</div>
                    </a>
                </li>
                <li class="nav-item" id="tab-symbol">
                    <a class="nav-link px-0 h-100 d-flex flex-column justify-content-center" id="orders-tab" href="#symbol" data-toggle="tab" role="tab" aria-controls="orders" aria-selected="false">
                        <div class="icon"><i class="logobot-icon icon-shield"></i></div>
                        <div>Symbol</div>
                    </a>
                </li>
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link px-0 h-100 d-flex flex-column justify-content-center" id="orders-tab" href="#container" data-toggle="tab" role="tab" aria-controls="orders" aria-selected="false">--}}
                        {{--<div class="icon"><i class="logobot-icon icon-containers"></i></div>--}}
                        {{--<div>Container</div>--}}
                    {{--</a>--}}
                {{--</li>--}}
                <li class="nav-item" id="tab-color">
                    <a class="nav-link px-0 h-100 d-flex flex-column justify-content-center" id="orders-tab" href="#color-scheme" data-toggle="tab" role="tab" aria-controls="orders" aria-selected="false">
                        <div class="icon"><i class="logobot-icon icon-colorscheme"></i></div>
                        <div style="line-height: 1;">Color Scheme</div>
                    </a>
                </li>
            </ul>
        </nav>

        <nav class="d-md-none navbar text-center mobile-nav p-0 invisible" style="font-size: 0.75rem;">
            <ul class="nav justify-content-between w-100" id="tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link px-0 active" id="info-tab" href="#name" data-toggle="tab" role="tab" aria-controls="info" aria-selected="true">
                        <div class="icon"><i class="logobot-icon icon-user-edit"></i></div>
                        <div>Name</div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-0" id="logos-tab" href="#slogan" data-toggle="tab" role="tab" aria-controls="logos" aria-selected="false">
                        <div class="icon"><i class="logobot-icon icon-font"></i></div>
                        <div>Slogan</div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-0" id="orders-tab" href="#symbol" data-toggle="tab" role="tab" aria-controls="orders" aria-selected="false">
                        <div class="icon"><i class="logobot-icon icon-shield"></i></div>
                        <div>Symbol</div>
                    </a>
                </li>
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link px-0" id="orders-tab" href="#container" data-toggle="tab" role="tab" aria-controls="orders" aria-selected="false">--}}
                        {{--<div class="icon"><i class="logobot-icon icon-containers"></i></div>--}}
                        {{--<div>Container</div>--}}
                    {{--</a>--}}
                {{--</li>--}}
                <li class="nav-item">
                    <a class="nav-link px-0" id="orders-tab" href="#color-scheme" data-toggle="tab" role="tab" aria-controls="orders" aria-selected="false">
                        <div class="icon"><i class="logobot-icon icon-colorscheme"></i></div>
                        <div style="line-height: 1;">Color Scheme</div>
                    </a>
                </li>
            </ul>
        </nav>

        <logo-save-success-modal
                :open="showStoreSuccessModal"
                @update-open="updateShowStoreSuccessModal"
        ></logo-save-success-modal>

        @if (\Auth::user()->isAdmin())
            <color-combination-save-modal
                    :open="showColorCombinationModal"
                    v-on:update-open="updateShowColorCombinationModal"
                    v-on:show-success-message="showSuccessMessage"
                    v-on:show-error-message="showErrorMessage"
            ></color-combination-save-modal>

            <font-combination-save-modal
                    :open="showFontCombinationModal"
                    v-on:update-open="updateShowFontCombinationModal"
                    v-on:show-success-message="showSuccessMessage"
                    v-on:show-error-message="showErrorMessage"
            ></font-combination-save-modal>
        @endif

        <loader></loader>

        <error-message-modal :open="showErrorMessageModal" :message="errorMessage" @update-open="updateShowErrorMessageModal"></error-message-modal>
        <success-message-modal :open="showSuccessMessageModal" :message="successMessage" @update-open="updateShowSuccessMessageModal"></success-message-modal>

        @include('components.logo_preview')
    </div>
@endsection

@section('scripts')
    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <script src="{{ mix('/js/editor.js') }}"></script>
@endsection