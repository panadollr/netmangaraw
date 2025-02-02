<div class="list-chapter" id="nt_listchapter">
    <h2 class="clearfix list-title">
        <i class="fa fa-list"></i> @lang('menu.chapter_list')
    </h2>
    <div class="heading row">
        <div class="col-xs-5 no-wrap"></div>
        <div class="col-xs-4 no-wrap text-center">@lang('menu.updated_at')</div>
    </div>
    <nav>
        <ul>
            @foreach ($manga->chapters as $index => $chapter)
                @php
                    $class = $index <= 10 ? 'row' : 'less row';
                @endphp
                <li class="{{ $class }}">
                    <div class="chapter col-xs-5">
                        <a
                            href="{{ route('manga.read', ['slug' => $manga->slug, 'chapter_number' => $chapter->chapter_number]) }}">
                            @lang('menu.chapter', ['number' => $chapter->chapter_number])
                        </a>
                    </div>
                    <div class="col-xs-4 no-wrap small text-center">
                        {{ diffForHumans($chapter->created_at) }}
                    </div>

                </li>
            @endforeach
        </ul>
        @if ($manga->chapters->count() > 10)
            <a class="hidden view-more" href="#"><i class="fa fa-plus"></i> @lang('menu.view_more')</a>
        @endif
    </nav>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const viewMoreButton = document.querySelector('.view-more');
        const hiddenItems = document.querySelectorAll('.less');

        viewMoreButton.addEventListener('click', (event) => {
            event.preventDefault();

            // Hiển thị tất cả các mục bị ẩn
            hiddenItems.forEach((item) => {
                item.classList.remove('less');
            });

            // Xóa nút "Xem thêm" khi tất cả các mục đã được hiển thị
            viewMoreButton.remove();
        });
    });
</script>
