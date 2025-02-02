@extends('frontend-web.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12 full-width" id="ctl00_divCenter">
                <div class="reading">
                    <div class="container">
                        <div class="top">

                            @include('frontend-web.partials.breadcrumb', [
                                'items' => array_filter([
                                    ['url' => route('home'), 'label' => __('menu.home'), 'active' => false],
                                    [
                                        'url' => route('mangas.search'),
                                        'label' => __('menu.mangas'),
                                        'active' => false,
                                    ],
                                    [
                                        'url' => route('manga.detail', ['slug' => $manga->slug]),
                                        'label' => limitString($manga->title, 50),
                                        'active' => true,
                                    ],
                                    [
                                        'url' => route('manga.read', [
                                            'slug' => $manga->slug,
                                            'chapter_number' => $currentChapter->chapter_number,
                                        ]),
                                        'label' => __('menu.chapter', [
                                            'number' => $currentChapter->chapter_number,
                                        ]),
                                        'active' => true,
                                    ],
                                ]),
                            ])

                            <h1 class="txt-primary">
                                <a href="{{ route('manga.detail', ['slug' => $manga->slug]) }}">{{ $manga->title }}</a>
                                <span>- @lang('menu.chapter', ['number' => $currentChapter->chapter_number])</span>
                            </h1>
                            <i>[@lang('menu.updated_at'): {{ $currentChapter->created_at }}]</i>
                        </div>
                        <div class="reading-control">
                            <div class="alert alert-info hidden-sm hidden-xs mrb10">
                                <i class="fa fa-info-circle"></i>
                                <em>@lang('menu.chapter_navigation')</em>
                            </div>
                            <div class="chapter-nav" id="chapterNav">
                                <a class="home" href="/" title="ほホー�&nbsp;"><i class="fa fa-home"></i></a>
                                <a class="backward home"
                                    href="{{ route('manga.detail', ['slug' => $manga->slug]) }}#nt_listchapter"
                                    title="{{ $manga->title }}"><i class="fa fa-list"></i></a>
                                @if ($previousChapter)
                                    <a class="a_prev prev"
                                        href="{{ route('manga.read', ['slug' => $manga->slug, 'chapter_number' => $previousChapter->chapter_number]) }}"><i
                                            class="fa fa-chevron-left"></i></a>
                                @else
                                    <a class="a_prev prev disabled" href="#"><i class="fa fa-chevron-left"></i></a>
                                @endif

                                <select class="select-chapter" id="ctl00_mainContent_ddlSelectChapter"
                                    name="ctl00$mainContent$ddlSelectChapter">
                                    <option
                                        value="{{ route('manga.read', ['slug' => $manga->slug, 'chapter_number' => $currentChapter->chapter_number]) }}">
                                        @lang('menu.chapter', ['number' => $currentChapter->chapter_number])</option>
                                </select>

                                @if ($nextChapter)
                                    <a class="a_next next"
                                        href="{{ route('manga.read', ['slug' => $manga->slug, 'chapter_number' => $nextChapter->chapter_number]) }}"><i
                                            class="fa fa-chevron-right"></i></a>
                                @else
                                    <a class="a_next next disabled" href="#"><i class="fa fa-chevron-right"></i></a>
                                @endif
                                <a class="btn btn-success follow-hidden" href="javascript:void(0)"><i
                                        class="fa fa-heart"></i>
                                    <span>@lang('menu.follow_btn')</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="box_doc reading-detail">
                        @php
                            $pages = $currentChapter->content;
                            $totalPages = count($pages);
                        @endphp

                        <!-- Notification Page -->
                        <div class="page-chapter" id="page_0}">
                            <img alt="{{ config('custom.frontend-name') }} - Page 0"
                                data-cdn="{{ asset('frontend-web/images/chapter_page_notify.jpg') }}" data-index="0"
                                data-original="{{ asset('frontend-web/images/chapter_page_notify.jpg') }}"
                                referrerpolicy="no-referrer"
                                src="{{ asset('frontend-web/images/chapter_page_notify.jpg') }}" loading="lazy" />
                        </div>
                        <!-- Pages -->
                        @foreach ($pages as $index => $page)
                            <div class="page-chapter {{ $index === $totalPages - 1 ? 'lazy-module' : '' }}"
                                data-type="{{ $index === $totalPages - 1 ? 'end-chapter' : '' }}"
                                id="page_{{ $index }}">
                                <img alt="{{ $manga->title }} - Page {{ $index }}" class="lazy"
                                    data-original="{{ $page }}"
                                    src="{{ asset(config('custom.preload_cover')) }}" />
                            </div>
                        @endforeach
                    </div>
                    <div class="container">
                        <div class="bottom top">
                            <div class="chapter-nav-bottom text-center" id="chapterNavBottom">
                                @if ($previousChapter)
                                    <a class="btn btn-danger prev"
                                        href="{{ route('manga.read', ['slug' => $manga->slug, 'chapter_number' => $previousChapter->chapter_number]) }}">
                                        <em class="fa fa-chevron-left"></em>
                                        @lang('menu.previous_chapter_btn')
                                    </a>
                                @endif

                                @if ($nextChapter)
                                    <a class="btn btn-danger next"
                                        href="{{ route('manga.read', ['slug' => $manga->slug, 'chapter_number' => $nextChapter->chapter_number]) }}">
                                        @lang('menu.next_chapter_btn')
                                        <em class="fa fa-chevron-right"></em>
                                    </a>
                                @endif
                            </div>

                            @include('frontend-web.partials.breadcrumb', [
                                'items' => array_filter([
                                    ['url' => route('home'), 'label' => __('menu.home'), 'active' => false],
                                    [
                                        'url' => route('mangas.search'),
                                        'label' => __('menu.mangas'),
                                        'active' => false,
                                    ],
                                    [
                                        'url' => route('manga.detail', ['slug' => $manga->slug]),
                                        'label' => limitString($manga->title, 50),
                                        'active' => true,
                                    ],
                                    [
                                        'url' => route('manga.read', [
                                            'slug' => $manga->slug,
                                            'chapter_number' => $currentChapter->chapter_number,
                                        ]),
                                        'label' => __('menu.chapter', [
                                            'number' => $currentChapter->chapter_number,
                                        ]),
                                        'active' => true,
                                    ],
                                ]),
                            ])

                            <div class="hidden social"></div>
                        </div>
                        <script src="{{ asset('frontend-web/js/chapterloader.min.js') }}"></script>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade in chapter-list-modal" id="chapterModal" tabindex="-1" role="dialog" data-backdrop="static"
        aria-hidden="false" style="display:none">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <input class="form-control" placeholder="@lang('menu.chapter_search_placeholder')" onkeyup="findChapter()">
                </div>
                <div class="modal-body chapter-list chapter">
                    @foreach ($chapters as $chapter)
                        <a id="chapter_{{ $chapter->id }}"
                            href="{{ route('manga.read', ['slug' => $manga->slug, 'chapter_number' => $chapter->chapter_number]) }}"
                            class="{{ $chapter->chapter_number === $currentChapter->chapter_number ? 'active' : '' }}"
                            title="@lang('menu.chapter', ['number' => $chapter->chapter_number])">
                            @lang('menu.chapter', ['number' => $chapter->chapter_number])
                        </a>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default">@lang('menu.close_btn')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectChapter = document.getElementById('ctl00_mainContent_ddlSelectChapter');
            const chapterModal = document.getElementById('chapterModal');
            const closeModalButtons = document.querySelectorAll('#closeModal, #closeModalFooter');

            selectChapter.addEventListener('click', function() {
                chapterModal.style.display = 'flex';
            });

            closeModalButtons.forEach(button => {
                button.addEventListener('click', function() {
                    chapterModal.style.display = 'none';
                });
            });

            selectChapter.addEventListener('mousedown', function(event) {
                event.preventDefault();
            });

            $('#chapterModal .close, .btn-default').on('click', function() {
                chapterModal.style.display = 'none';
            });
        });
    </script>

    <script>
        function addToHistory(chapterId) {
            let historyIds = JSON.parse(localStorage.getItem('historyIds')) || [];
            if (!historyIds.includes(chapterId)) {
                historyIds.push(chapterId);
                localStorage.setItem('historyIds', JSON.stringify(historyIds));
            }
        }

        let currentChapterId = {{ $manga->id }};
        addToHistory(currentChapterId);
    </script>
@endsection
