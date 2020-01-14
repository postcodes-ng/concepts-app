@extends('layouts.canopy')

@section('title', 'Contact Us')

@section('description', 'Contact Postcodes dot NG')

@push('styles')
    <link href="{{ mix('css/contact.css') }}" rel="stylesheet">
@endpush

@section('body')

@include('nav.nav')

    <div itemscope itemtype="http://schema.org/WebSite">
        <link itemprop="url" href="http://www.postcodes.ng/contact"/>
        <meta itemprop="name" content="Contact"/>
        <meta itemprop="description" content="Contact Postcodes dot NG"/>
    </div>
    <div id="npc-page">
        <div class="npc-section-wrapper">
            <section class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="npc-contact-container">
                        <div class="npc-contact-wrap">
                            <form class="npc-contact-form">
                                <span class="npc-contact-form-title">
                                    Send Us A Message
                                </span>
                                <div id="cf-result" class="npc-contact-form-result npc-hidden">
                                    <div id="cf-error" class="alert alert-danger npc-hidden" role="alert">
                                        <span></span>
                                    </div>
                                    <div id="cf-success" class="alert alert-success npc-hidden" role="alert">
                                        <span></span>
                                    </div>
                                </div>

                                <label class="npc-input-label" for="first-name">
                                    Tell us your name
                                    <span class="npc-required-label">*</span>
                                </label>
                                <div class="npc-input-wrap npc-left-input-wrap
                                npc-input-validate"
                                data-validate="Type first name">
                                    <input id="first-name" class="npc-input" type="text" name="first-name"
                                    placeholder="First name">
                                    <span class="npc-input-focus"></span>
                                </div>
                                <div class="npc-input-wrap npc-right-input-wrap
                                npc-input-validate"
                                data-validate="Type last name">
                                    <input id="last-name" class="npc-input" type="text" name="last-name" placeholder="Last name">
                                    <span class="npc-input-focus"></span>
                                </div>

                                <label class="npc-input-label" for="email">
                                    Enter your email
                                    <span class="npc-required-label">*</span>
                                </label>
                                <div class="npc-input-wrap
                                npc-input-validate"
                                data-validate = "Valid email is required">
                                    <input id="email" class="npc-input" type="text" name="email"
                                    placeholder="example@email.com">
                                    <span class="npc-input-focus"></span>
                                </div>

                                <label class="npc-input-label" for="phone">
                                    Enter phone number
                                </label>
                                <div class="npc-input-wrap">
                                    <input id="phone" class="npc-input" type="text" name="phone"
                                    placeholder="+234 80 30000001">
                                    <span class="npc-input-focus"></span>
                                </div>

                                <label class="npc-input-label" for="message">
                                    Message
                                    <span class="npc-required-label">*</span>
                                </label>
                                <div class="npc-input-wrap
                                npc-input-validate"
                                data-validate = "Message is required">
                                    <textarea id="message" class="npc-input" name="message"
                                    placeholder="Write us a message">
                                    </textarea>
                                    <span class="npc-input-focus"></span>
                                </div>

                                <div class="npc-contact-container-form-btn">
                                    <button id="cf-btn" class="npc-contact-form-btn">
                                        Send Message
                                    </button>
                                    <!-- spinner -->
                                    &nbsp;&nbsp;&nbsp;<span id="cf-loading" class="npc-spinner-medium npc-hidden"></span>
                                </div>
                            </form>

                            <div class="npc-contact-detail">
                                <div class="npc-flex-col-c-m">
                                    <div class="flex-w size1 p-b-47">

                                        <div class="npc-flex-col size2">
                                            <span class="txt1 p-b-20">
                                                Address
                                            </span>

                                            <span class="txt2">
                                                16 Alaenyi St, Owerri, Imo State 460221 Nigeria
                                            </span>
                                        </div>
                                    </div>

                                    <!-- <div class="dis-flex size1 p-b-47">

                                        <div class="npc-flex-col size2">
                                        <span class="txt1 p-b-20">
                                            Lets Talk
                                        </span>

                                            <span class="txt3">
                                            +1 800 1236879
                                        </span>
                                        </div>
                                    </div> -->

                                    <div class="dis-flex size1 p-b-47">

                                        <div class="npc-flex-col size2">
                                        <span class="txt1 p-b-20">
                                            General Support
                                        </span>

                                            <span class="txt3">
                                            info@postcodes.ng
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/npc-contact.js') }}"></script>
@endpush
