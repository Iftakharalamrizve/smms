@extends('layout.app')

@section('content')
<main class="g-page-wrap">

    <div class="g-page-content-area">

        <div class="g-page-content-main">
            <div class="container-fluid mb-3">
                    <div class="g-social-connect-area">
                        <div id="loading">
                            <svg id="loading-main" x="0px" y="0px"
                                 viewBox="0 0 100 100">
                                <path fill="#E56B6F" d="M31.6,3.5C5.9,13.6-6.6,42.7,3.5,68.4c10.1,25.7,39.2,38.3,64.9,28.1l-3.1-7.9c-21.3,8.4-45.4-2-53.8-23.3
  c-8.4-21.3,2-45.4,23.3-53.8L31.6,3.5z">
                                    <animateTransform
                                        attributeName="transform"
                                        attributeType="XML"
                                        type="rotate"
                                        dur="2s"
                                        from="0 50 50"
                                        to="360 50 50"
                                        repeatCount="indefinite"/>
                                </path>
                                <path fill="#E56B6F" d="M42.3,39.6c5.7-4.3,13.9-3.1,18.1,2.7c4.3,5.7,3.1,13.9-2.7,18.1l4.1,5.5c8.8-6.5,10.6-19,4.1-27.7
  c-6.5-8.8-19-10.6-27.7-4.1L42.3,39.6z">
                                    <animateTransform
                                        attributeName="transform"
                                        attributeType="XML"
                                        type="rotate"
                                        dur="1s"
                                        from="0 50 50"
                                        to="-360 50 50"
                                        repeatCount="indefinite"/>
                                </path>
                                <path fill="#E56B6F" d="M82,35.7C74.1,18,53.4,10.1,35.7,18S10.1,46.6,18,64.3l7.6-3.4c-6-13.5,0-29.3,13.5-35.3s29.3,0,35.3,13.5
  L82,35.7z">
                                    <animateTransform
                                        attributeName="transform"
                                        attributeType="XML"
                                        type="rotate"
                                        dur="2s"
                                        from="0 50 50"
                                        to="360 50 50"
                                        repeatCount="indefinite"/>
                                </path>
                            </svg>
                        </div>
                        <div class="g-social-main">
                            <div class="card">
                                <div class="card-body">
                                    <!--*********************************************************
                                          All Social Tabs And First Label Tabs Start From Here
                                     *************************************************************-->
                                    <div class="g-social-brand-area">
                                        <div class="g-social-brand-main" role="tablist" id="social-tab">
                                            @if(isset($dataPack->platform))
                                                @foreach ($dataPack->platform as $items)
                                                    @if($items == 'Facebook')
                                                        <div class="g-social-single nav-link" data-bs-toggle="tab" data-bs-target="#facebook" role="presentation" data-profile="facebook">
                                                            <i class="bi bi-facebook"></i>
                                                            Facebook
                                                        </div>
                                                    @endif
                                                    @if($items == 'Twitter')
                                                        <div class="g-social-single nav-link" data-bs-toggle="tab" data-bs-target="#twitter" role="presentation" data-profile="twitter">
                                                            <i class="bi bi-twitter"></i>
                                                            Twitter
                                                        </div>
                                                    @endif
                                                    @if($items == 'Instagram')
                                                        <div class="g-social-single nav-link" data-bs-toggle="tab"  data-bs-target="#instagram" role="presentation" data-profile="instagram">
                                                            <i class="bi bi-instagram"></i>
                                                            Instagram
                                                        </div>
                                                    @endif
                                                    @if($items == 'WhatsApp')
                                                        <div class="g-social-single nav-link" data-bs-toggle="tab" ddata-bs-target="#whatsapp" data-profile="whatsapp" role="presentation">
                                                            <i class="bi bi-whatsapp"></i>
                                                            Whatsapp
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>

                                        <div class="g-social-disposition-area me-1">
                                            <select class="form-select form-select-sm bg-warning text-bg-warning"
                                                    aria-label=".form-select-sm example">
                                                <option  value="ready">Ready</option>
                                                <option  value="busy">Busy</option>
                                                <option value="idle">Break</option>
                                                <option value="logout">Logout</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="g-social-profile-area tab-content" id="social-tab-content">

                                        <div class="tab-pane fade show active" id="facebook" role="tabpanel"
                                             aria-labelledby="social-facebook-tab">

                                            <!--********************************************
                                                   Start Second and Inner First Label
                                                   Tabs Start Here
                                            *********************************************-->
                                            <!-- All registered profile against social brands-->
                                            @php  
                                                $listData = [
                                                    [
                                                        'id' => 123,
                                                        'name' => 'Genuity Systems Limited'
                                                    ],
                                                    [
                                                        'id' => 1234,
                                                        'name' => 'gPlex'
                                                    ]
                                                ];
                                            @endphp 
                                            <div class="g-social-individual-profile" role="tablist">
                                                @foreach($listData as $key=>$page)
                                                    <div class="g-social-individual-main{{$key==0?' active':''}}" data-bs-toggle="tab" data-bs-target="#page{{$page['id']}}">
                                                        <i class="bi bi-exclude"></i>
                                                        {{$page['name']}}
                                                        <sup class="badge badge-success rounded-pill bg-danger">8</sup>
                                                    </div>
                                                @endforeach
                                            </div>


                                            <div class="tab-content">
                                                @foreach($listData as $key=>$page)
                                                <div class="g-social-profile-single-details tab-pane fade show {{$key==0?' active':''}} page-content-{{$page['id']}}"
                                                     id="page{{$page['id']}}" role="tablist">
                                                    <!-- All social meta for each social profile-->
                                                    <div class="g-social-meta-area">

                                                        <!--********************************************
                                                               Start Third and Inner Second Label
                                                                       Tabs Start Here
                                                         *********************************************-->
                                                        <div class="g-meta-single active" data-bs-toggle="tab"
                                                             data-bs-target="#post{{$page['id']}}">
                                                            <i class="bi bi-send-fill"></i> Post
                                                            <sup
                                                                class="badge badge-success rounded-pill bg-danger page-post-notification-123">5</sup>
                                                        </div>

                                                        <div class="g-meta-single" data-bs-toggle="tab"
                                                             data-bs-target="#message{{$page['id']}}">
                                                            <i class="bi bi-chat-left-fill"></i> Message
                                                            <sup
                                                                class="badge badge-success rounded-pill bg-danger page-message-notification-123">3</sup>
                                                        </div>

                                                    </div>

                                                    <div class="tab-content page-content-area-{{$page['id']}}">
                                                        <!-- Each Profile Chat Items Area-->
                                                        <div class="tab-pane fade show active page-post-content-{{$page['id']}}" role="tabpanel"
                                                             id="post{{$page['id']}}">
                                                            <div class="g-social-chat-area">

                                                                <!-- Post Items-->
                                                                <div class="g-social-post-item-area">

                                                                    <div class="g-social-common-header">
                                                                        <div class="g-social-registered-brand">
                                                                            <img src="https://picsum.photos/55/55"
                                                                                 alt="">
                                                                        </div>

                                                                        <div>
                                                                            <button
                                                                                class="btn btn-outline-primary btn-sm"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#social-create-post">
                                                                                create post
                                                                            </button>
                                                                        </div>

                                                                    </div>


                                                                    <!-- Search Form-->
                                                                    <div class="g-search-form-area">
                                                                        <form action="">
                                                                            <div class="form-group">
                                                                                <label for="g-post-search"
                                                                                       class="w-100">
                                                                                    <input class="form-control"
                                                                                           type="search" name=""
                                                                                           id="g-post-search">
                                                                                    <i class="bi bi-search g-search-icon"></i>
                                                                                </label>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <!-- End Search Form-->

                                                                    <div class="g-social-post-list" role="tablist">

                                                                        <div class="g-social-post-single position-relative clearfix">
                                                                            <div class="g-social-post-single-content">
                                                                                <div>
                                                                                    <img
                                                                                        src="https://picsum.photos/60/60"
                                                                                        alt="">
                                                                                </div>
                                                                                <div>
                                                                                    Lorem ipsum dolor sit amet,
                                                                                    consectetur adipisicing elit.
                                                                                </div>
                                                                            </div>


                                                                            <button data-bs-toggle="tab"
                                                                                    data-bs-target="#preview-1"
                                                                                    class="g-post-preview-link float-end fade show active">
                                                                                preview
                                                                            </button>

                                                                        </div>

                                                                        <div
                                                                            class="g-social-post-single position-relative clearfix">
                                                                            <div class="g-social-post-single-content">
                                                                                <div>
                                                                                    <img
                                                                                        src="https://picsum.photos/60/60"
                                                                                        alt="">
                                                                                </div>
                                                                                <div>
                                                                                    Lorem ipsum dolor sit amet,
                                                                                    consectetur adipisicing elit.
                                                                                </div>
                                                                            </div>


                                                                            <button data-bs-toggle="tab"
                                                                                    data-bs-target="#preview-2"
                                                                                    class="g-post-preview-link float-end fade show">
                                                                                preview
                                                                            </button>

                                                                        </div>

                                                                        <div
                                                                            class="g-social-post-single position-relative clearfix">
                                                                            <div class="g-social-post-single-content">
                                                                                <div>
                                                                                    <img
                                                                                        src="https://picsum.photos/60/60"
                                                                                        alt="">
                                                                                </div>
                                                                                <div>
                                                                                    Lorem ipsum dolor sit amet,
                                                                                    consectetur adipisicing elit.
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                        <div
                                                                            class="g-social-post-single position-relative clearfix">
                                                                            <div class="g-social-post-single-content">
                                                                                <div>
                                                                                    <img
                                                                                        src="https://picsum.photos/60/60"
                                                                                        alt="">
                                                                                </div>
                                                                                <div>
                                                                                    Lorem ipsum dolor sit amet,
                                                                                    consectetur adipisicing elit.
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                        <div
                                                                            class="g-social-post-single position-relative clearfix">
                                                                            <div class="g-social-post-single-content">
                                                                                <div>
                                                                                    <img
                                                                                        src="https://picsum.photos/60/60"
                                                                                        alt="">
                                                                                </div>
                                                                                <div>
                                                                                    Lorem ipsum dolor sit amet,
                                                                                    consectetur adipisicing elit.
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                        <div
                                                                            class="g-social-post-single position-relative clearfix">
                                                                            <div class="g-social-post-single-content">
                                                                                <div>
                                                                                    <img
                                                                                        src="https://picsum.photos/60/60"
                                                                                        alt="">
                                                                                </div>
                                                                                <div>
                                                                                    Lorem ipsum dolor sit amet,
                                                                                    consectetur adipisicing elit.
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                    </div>

                                                                </div>
                                                                <!-- End Post Items-->

                                                                <!-- Comments Items-->
                                                                <div class="g-social-comment-list-area">

                                                                    <div class="g-social-common-header">
                                                                        <h5>Post Preview</h5>
                                                                        <span></span>
                                                                    </div>
                                                                    <hr/>
                                                                    <!-- Search Form-->
                                                                    <div class="g-search-form-area">
                                                                        <form action="" class="visually-hidden">
                                                                            <div class="form-group">
                                                                                <label for="g-comment-search"
                                                                                       class="w-100">
                                                                                    <input class="form-control"
                                                                                           type="search" name=""
                                                                                           id="g-comment-search">
                                                                                    <i class="bi bi-search g-search-icon"></i>
                                                                                </label>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <!-- End Search Form-->

                                                                    <div
                                                                        class="g-social-comment-list flex-shrink-0 tab-content">

                                                                        <div
                                                                            class="g-post-preview tab-pane fade show active"
                                                                            id="preview-1"
                                                                            role="tabpanel">
                                                                            <p>Lorem ipsum dolor sit amet, consectetur
                                                                                adipisicing elit. Ab maiores minima
                                                                                minus quam tempora temporibus!</p>
                                                                            <img class="img-fluid"
                                                                                 src="https://picsum.photos/500/300"
                                                                                 alt="">
                                                                        </div>

                                                                        <div class="g-post-review tab-pane fade show"
                                                                             id="preview-2"
                                                                             role="tabpanel">
                                                                            <p>Lorem ipsum dolor sit amet, consectetur
                                                                                adipisicing elit.</p>
                                                                            <img class="img-fluid"
                                                                                 src="https://picsum.photos/550/300"
                                                                                 alt="">
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                                <!-- End Comments Items-->

                                                                <!--Comments Reply-->
                                                                <div class="g-social-comment-reply-area">
                                                                    <div class="g-social-common-header">
                                                                        <div class="g-social-registered-brand">
                                                                            <img src="https://picsum.photos/55/55"
                                                                                 alt="">
                                                                            <h5>
                                                                                Genuity
                                                                                Systems
                                                                                Limited</h5>
                                                                        </div>

                                                                        <div>
                                                                            Comments
                                                                            <sup
                                                                                class="badge badge-success rounded-pill bg-danger">5</sup>
                                                                        </div>
                                                                    </div>
                                                                    <hr/>

                                                                    <div class="g-social-comment-reply-main">

                                                                        <div class="g-social-messages">

                                                                            <div class="g-social-msg-self">
                                                                                <div class="g-social-msg-self-image">
                                                                                    <img
                                                                                        src="https://picsum.photos/60/60"
                                                                                        alt="">
                                                                                </div>
                                                                                <div class="g-social-msg-self-text">
                                                                                    Lorem ipsum dolor sit amet,
                                                                                    consectetur adipisicing elit.
                                                                                    Consectetur consequuntur eaque
                                                                                    explicabo harum iusto non nulla
                                                                                    numquam, obcaecati odio voluptas!

                                                                                    <div
                                                                                        class="d-flex justify-content-between align-items-baseline w-100">

                                                                                        <div class="g-message-datetime">
                                                                                            <small>12-20-23 <span>10:20 am</span></small>
                                                                                        </div>
                                                                                        <div
                                                                                            class="g-social-msg-self-meta">

                                                                                        <span
                                                                                            class="badge bg-warning cursor-pointer"> hide</span>
                                                                                            <span
                                                                                                class="badge bg-danger cursor-pointer"> delete</span>
                                                                                            <span
                                                                                                class="badge bg-primary cursor-pointer">reply</span>
                                                                                            <span
                                                                                                class="badge bg-success cursor-pointer"> private reply</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="g-social-msg-self">
                                                                                <div class="g-social-msg-self-image">
                                                                                    <img
                                                                                        src="https://picsum.photos/60/60"
                                                                                        alt="">
                                                                                </div>
                                                                                <div class="g-social-msg-self-text">
                                                                                    Lorem ipsum dolor sit amet,
                                                                                    consectetur adipisicing elit.
                                                                                    Consectetur consequuntur eaque
                                                                                    explicabo harum iusto non nulla
                                                                                    numquam, obcaecati odio voluptas!

                                                                                    <div
                                                                                        class="d-flex justify-content-between align-items-baseline w-100">

                                                                                        <div class="g-message-datetime">
                                                                                            <small>12-20-23 <span>10:20 am</span></small>
                                                                                        </div>
                                                                                        <div
                                                                                            class="g-social-msg-self-meta">

                                                                                        <span
                                                                                            class="badge bg-warning cursor-pointer"> hide</span>
                                                                                            <span
                                                                                                class="badge bg-danger cursor-pointer"> delete</span>
                                                                                            <span
                                                                                                class="badge bg-primary cursor-pointer">reply</span>
                                                                                            <span
                                                                                                class="badge bg-success cursor-pointer"> private reply</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="g-social-msg-self">
                                                                                <div class="g-social-msg-self-image">
                                                                                    <img
                                                                                        src="https://picsum.photos/60/60"
                                                                                        alt="">
                                                                                </div>
                                                                                <div class="g-social-msg-self-text">
                                                                                    Lorem ipsum dolor sit amet,
                                                                                    consectetur adipisicing elit.
                                                                                    Consectetur consequuntur eaque
                                                                                    explicabo harum iusto non nulla
                                                                                    numquam, obcaecati odio voluptas!

                                                                                    <div
                                                                                        class="d-flex justify-content-between align-items-baseline w-100">

                                                                                        <div class="g-message-datetime">
                                                                                            <small>12-20-23 <span>10:20 am</span></small>
                                                                                        </div>
                                                                                        <div
                                                                                            class="g-social-msg-self-meta">

                                                                                        <span
                                                                                            class="badge bg-warning cursor-pointer"> hide</span>
                                                                                            <span
                                                                                                class="badge bg-danger cursor-pointer"> delete</span>
                                                                                            <span
                                                                                                class="badge bg-primary cursor-pointer">reply</span>
                                                                                            <span
                                                                                                class="badge bg-success cursor-pointer"> private reply</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="g-social-msg-other">
                                                                        <span class="g-social-msg-other-image">
                                                                            <img src="https://picsum.photos/60/60"
                                                                                 alt="">
                                                                        </span>
                                                                                <span class="g-social-msg-other-text">
                                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur consequuntur eaque explicabo harum iusto non nulla numquam, obcaecati odio voluptas!
                                                                </span>
                                                                            </div>

                                                                            <div class="g-social-msg-other">
                                                                        <span class="g-social-msg-other-image">
                                                                            <img src="https://picsum.photos/60/60"
                                                                                 alt="">
                                                                        </span>
                                                                                <span class="g-social-msg-other-text">
                                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur consequuntur eaque explicabo harum iusto non nulla numquam, obcaecati odio voluptas!
                                                                </span>
                                                                            </div>
                                                                            <div class="g-social-msg-other">
                                                                        <span class="g-social-msg-other-image">
                                                                            <img src="https://picsum.photos/60/60"
                                                                                 alt="">
                                                                        </span>
                                                                                <span class="g-social-msg-other-text">
                                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur consequuntur eaque explicabo harum iusto non nulla numquam, obcaecati odio voluptas!
                                                                </span>
                                                                            </div>
                                                                            <div class="g-social-msg-other">
                                                                        <span class="g-social-msg-other-image">
                                                                            <img src="https://picsum.photos/60/60"
                                                                                 alt="">
                                                                        </span>
                                                                                <span class="g-social-msg-other-text">
                                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur consequuntur eaque explicabo harum iusto non nulla numquam, obcaecati odio voluptas!
                                                                </span>
                                                                            </div>
                                                                        </div>


                                                                        <div class="g-social-messages-footer">
                                                                            <div class="g-disposition-select mb-2 w-25">
                                                                                <select class="form-select"
                                                                                        aria-label="Default select example">
                                                                                    <option value="" selected>Select
                                                                                        Disposition
                                                                                    </option>
                                                                                    <option value="1">One</option>
                                                                                    <option value="2">Two</option>
                                                                                    <option value="3">Three</option>
                                                                                </select>
                                                                            </div>

                                                                            <textarea class="form-control" name=""
                                                                                      cols="30"
                                                                                      rows="3"
                                                                                      placeholder="Write here..."></textarea>
                                                                            <button
                                                                                class="btn btn-primary text-white w-100 mt-2">
                                                                                Reply
                                                                            </button>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <!--End Comments Reply-->
                                                            </div>
                                                        </div>

                                                        <div class="tab-pane fade show page-message-content-123" role="tabpanel"
                                                             id="message{{$page['id']}}">

                                                            <div class="g-social-chat-area">

                                                                <!-- Post Items-->
                                                                <div class="g-social-post-item-area">

                                                                    <div class="g-social-common-header">
                                                                        <div class="g-social-registered-brand">
                                                                            <img src="https://picsum.photos/55/55"
                                                                                 alt="">
                                                                        </div>

                                                                        <div>
                                                                            <button
                                                                                class="btn btn-outline-primary btn-sm"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#social-create-post">
                                                                                create post test
                                                                            </button>
                                                                        </div>

                                                                    </div>


                                                                    <!-- Search Form-->
                                                                    <div class="g-search-form-area">
                                                                        <form action="">
                                                                            <div class="form-group">
                                                                                <label for="g-post-search"
                                                                                       class="w-100">
                                                                                    <input class="form-control"
                                                                                           type="search" name=""
                                                                                    >
                                                                                    <i class="bi bi-search g-search-icon"></i>
                                                                                </label>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <!-- End Search Form-->

                                                                    <div class="g-social-post-list message-list-{{$page['id']}}">
                                                                        @if($dataPack->socialMessageData[$page['id']]??false)
                                                                            @foreach($dataPack->socialMessageData[$page['id']] as $key=>$sessionItem)
                                                                                <div onclick="getSessionMessage('{{ $sessionItem['session_id'] }}','{{$page['id']}}')" class="g-social-post-single position-relative clearfix message-item-{{$sessionItem['session_id']}}">
                                                                                    <div class="g-social-post-single-content">
                                                                                        <div class="message-image-{{$sessionItem['session_id']}}">
                                                                                            <img src="https://picsum.photos/60/60" alt="">
                                                                                        </div>
                                                                                        <div class="message-text-{{$sessionItem['session_id']}}">
                                                                                            {{$sessionItem['message_text']}}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <!-- End Post Items-->

                                                                <!--Comments Reply-->
                                                                <div class="g-social-chatapp-area g-flex-grow">
                                                                    <div class="g-social-common-header">
                                                                        <div class="g-social-registered-brand">
                                                                            <img src="https://picsum.photos/55/55"
                                                                                 alt="">
                                                                            <h5>Genuity Systems Limited</h5>
                                                                        </div>

                                                                        <div>
                                                                            Details Profile
                                                                        </div>
                                                                    </div>
                                                                    <hr/>

                                                                    <div class="g-social-chatapp-main" id="g-social-chatapp-main-{{$page['id']}}">

                                                                        <div class="g-chatapp-messages" id="g-chatapp-messages-{{$page['id']}}">
                                                                            

                                                                        </div>


                                                                        <div class="g-chatapp-messages-footer" id="g-chatapp-messages-footer-{{$page['id']}}">


                                                                            <form method="post" action="{{route('agent.message.reply')}}" class="w-100">
                                                                                @csrf
                                                                                <div
                                                                                    class="g-disposition-select w-25 mb-2">
                                                                                    <input type="hidden" name="session_id" id="session_id_{{$page['id']}}">
                                                                                    <input type="hidden" name="page_id" value="{{$page['id']}}">
                                                                                    <select name="disposition_id" class="form-select"
                                                                                            aria-label="Default select example"
                                                                                            id="">
                                                                                        <option selected>Select
                                                                                            Disposition
                                                                                        </option>
                                                                                        <option value="1">One</option>
                                                                                        <option value="2">Two</option>
                                                                                        <option value="3">Three</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="g-chat-bottom-write">
                                                                                    <div class="g-chat-bottom-textarea">
                                                                                        <textarea class="form-control"
                                                                                                name="reply"
                                                                                                id="g-disposition-textarea"
                                                                                                placeholder="Write here..."
                                                                                                required></textarea>
                                                                                    </div>
                                                                                    <div class="g-chat-submit-btn">
                                                                                        <button  type="submit">
                                                                                            <i class="ph-fill ph-paper-plane"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>

                                                                            </form>

                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <!--End Comments Reply-->

                                                            </div>
                                                        </div>
                                                        <!--End Each Profile Chat Items Area-->
                                                    </div>

                                                    <!--End Third and Inner Second Label
                                                    Tabs Here-->

                                                </div>
                                                @endforeach
                                            </div>

                                            <!-- End Second and Inner First Label
                                             Tabs  Here-->
                                        </div>

                                    </div>

                                    <!-- End First Label Tabs-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </div>
        <!--Create Post-->
    <div class="modal modal-lg fade" id="social-create-post" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <textarea class="form-control mb-3" name="" cols="30" rows="8"></textarea>
                        <input class="form-control" type="file" name="" placeholder="attachment">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Create Post</button>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script defer src="{{ asset('assets/js/utils.js') }}"></script>
    <script defer src="{{ asset('assets/js/api-configuration.js') }}"></script>
    <script defer src="{{ asset('assets/js/social-media.js') }}"></script>
    <script>
        let currentActiveTabPageSession = {};
        
        function createMessageElement(message) {
            const messageDiv = document.createElement("div");
            messageDiv.classList.add(
                message.direction === "IN" ? "g-chatapp-msg-self" : "g-chatapp-msg-other"
            );

            const imageDiv = document.createElement("div");
            imageDiv.classList.add("g-chatapp-msg-self-image");

            const image = document.createElement("img");
            image.src = "https://picsum.photos/60/60";
            image.alt = "";

            imageDiv.appendChild(image);

            const textDiv = document.createElement("div");
            textDiv.classList.add("g-chatapp-msg-self-text");
            textDiv.innerHTML = message.message_text;

            const dateTimeDiv = document.createElement("div");
            dateTimeDiv.classList.add("d-flex", "justify-content-between", "align-items-baseline", "w-100");

            const timeDiv = document.createElement("div");
            timeDiv.classList.add("g-message-datetime");
            const timeSmall = document.createElement("small");
            timeSmall.innerText = message.created_at?message.created_at:message.assign_time;
            timeDiv.appendChild(timeSmall);
            dateTimeDiv.appendChild(timeDiv);

            if (message.direction === "IN") {
                const metaDiv = document.createElement("div");
                metaDiv.classList.add("g-chatapp-msg-self-meta");

                const badges = ["hide", "delete", "reply", "private reply"];
                for (const badgeText of badges) {
                    const badgeSpan = document.createElement("span");
                    const badgeColor =
                                        badgeText == 'hide' ? 'bg-warning' :
                                        badgeText == 'delete' ? 'bg-danger' :
                                        badgeText == 'reply' ? 'bg-primary' :
                                        'bg-success';
                    badgeSpan.classList.add("badge",badgeColor,"cursor-pointer");
                    badgeSpan.innerText = badgeText;
                    metaDiv.appendChild(badgeSpan);
                }

                dateTimeDiv.appendChild(metaDiv);
            }

            textDiv.appendChild(dateTimeDiv);

            messageDiv.appendChild(imageDiv);
            messageDiv.appendChild(textDiv);

            return messageDiv;
        }

        async function getSessionMessage(sessionId,pageID){
            let currentPageActiveStatus= currentActiveTabPageSession.hasOwnProperty(pageID);
            if(currentPageActiveStatus){
                if(currentActiveTabPageSession[pageID] != sessionId){
                    currentActiveTabPageSession[pageID] = sessionId;
                    document.getElementById('session_id_'+pageID).value = sessionId;
                }
            }else{
                currentActiveTabPageSession[pageID] = sessionId;
                document.getElementById('session_id_'+pageID).value = sessionId;
            }
            let data = new Object();
            data.session_id = sessionId;
            try {
                openLoader();
                data = JSON.stringify(data);
                let response = await callRequest('/get-session-sms','POST',data);
                response = JSON.parse(response).data;
                const container = document.getElementById('g-chatapp-messages-'+pageID);
                container.innerHTML="";
                for (const message of response) {
                    const messageElement = createMessageElement(message);
                    container.appendChild(messageElement);
                }
                closeLoader();
                return response;
            } catch (error) {
                closeLoader();
            }
        }
        
        function agentNewSessionCreate(data){
            const newSessionElement = document.createElement('div');
            newSessionElement.onclick = function() {
                getSessionMessage(data.session_id, data.page_id);
            };
            // newSessionElement.addEventListener('click',getSessionMessage(`${data.session_id}`,`${data.page_id}`));
            newSessionElement.className = `g-social-post-single position-relative clearfix message-item-${data.session_id}`;
            newSessionElement.innerHTML = `
                <div class="g-social-post-single-content">
                    <div class="message-image-${data.session_id}">
                        <img src="https://picsum.photos/60/60" alt="">
                    </div>
                    <div class="message-text-${data.session_id}">
                        ${data.message_text}
                    </div>
                </div>
            `;
            // Get the target container element
            const messageListContainer = document.querySelector(`.message-list-${data.page_id}`);

            // Append the new element to the target container
            messageListContainer.appendChild(newSessionElement);
        }

        function checkSessionAlreadyExist(session_id){
            const existingElement = document.querySelector(`.message-item-${session_id}`);
            if(existingElement){
                return true ;
            }
            return false;
        }

        function existingSessionMessageUpdate(data){
            const existingElement = document.querySelector(`.message-text-${data.session_id}`);
            const existingElement2 = document.querySelector(`.message-item-${data.session_id}`);
            console.log(`.message-text-${data.session_id}`);
            console.log(existingElement,existingElement2)
            existingElement.textContent = data.message_text;
            if(currentActiveSession[data.page_id] == data.session_id){
                const container = document.getElementById('g-chatapp-messages-'+data.page_id);
                const messageElement = createMessageElement(data);
                container.appendChild(messageElement);
            }
        }

        window.addEventListener('load', function () {
            Echo.private(`social_chat_room.{{ $username }}`)
            .listen('.agent_chat_room_event', (event) => {
                console.log(event);
                let status = checkSessionAlreadyExist(event.session_id)
                if(status){
                    existingSessionMessageUpdate(event);
                }else{
                    agentNewSessionCreate(event);
                }
                test();
            })
            .listenForWhisper('typing', (e) => {
                console.log("Received whisper:");
                console.log(e);
            })
            .error((error) => {
                console.error(error);
            });
             
        }, false);
    </script>
@endpush

