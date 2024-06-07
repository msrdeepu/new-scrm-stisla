@extends('messenger.layouts.app')

@section('content')
    <!--==================================Chatting Application Start===================================-->
    <section class="wsus__chat_app show_info">

        @include('messenger.layouts.user-list-sidebar')

        <div class="wsus__chat_area">

            <div class="wsus__message_paceholder d-none"></div>
            <div class="wsus__message_paceholder_black d-flex justify-content-center align-items-center">
                <span class="nothing_share badge bg-secondary text-white select_a_user">Select a chat to start
                    conversation</span>
            </div>

            <div class="wsus__chat_area_header">
                <div class="header_left messenger-header">
                    <span class="back_to_list">
                        <i class="fas fa-arrow-left"></i>
                    </span>
                    <img src="" alt="User" class="img-fluid">
                    <h4 class="messege-header-title"></h4>
                </div>
                <div class="header_right">
                    <a href="#" class="favourite"><i class="fas fa-star"></i></a>
                    <a href="#" class="go_home"><i class="fas fa-home"></i></a>
                    <a href="#" class="info"><i class="fas fa-info-circle"></i></a>
                </div>
            </div>

            <div class="wsus__chat_area_body">






            </div>

            <div class="wsus__chat_area_footer">
                <div class="footer_message">

                    <div class="img d-none attachment-block">
                        <img src="{{ asset('backend/cassets/images/chat_img.png') }}" alt="User"
                            class="img-fluid attachment-preview">
                        <span class="cancel-attachment"><i class="far fa-times"></i></span>
                    </div>

                    <form action="#" class="messege-form">
                        <div class="file">
                            <label for="file"><i class="far fa-plus"></i></label>
                            <input name="attachment" id="file" type="file" hidden class="attachment-input"
                                accept="image/*">
                        </div>
                        <textarea name="message" class="message-input" id="example1" rows="1" placeholder="Type a message.."></textarea>
                        <button type="submit"><i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
        </div>

        @include('messenger.layouts.user-info-sidebar')

    </section>
    <!--==================================
                                                                                                                                                                                                                                    Chatting Application End
                                                                                                                                                                                                                                ===================================-->
@endsection
