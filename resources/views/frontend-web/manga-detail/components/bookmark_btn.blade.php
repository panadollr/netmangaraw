<div class="follow">
    <a class="follow-link btn btn-success" href="javascript:void(0)" rel="nofollow noindex">
        <i class="fa fa-heart"></i> <span>@lang('menu.follow_btn')</span>
    </a>
</div>

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const comicId = "{{ $manga->id }}";

            function isComicBookmarked(comicId) {
                let bookmarkIds = JSON.parse(localStorage.getItem("bookmarkIds")) || [];
                return bookmarkIds.includes(comicId);
            }

            function updateFollowStatus(comicId) {
                const followLink = document.querySelector('.follow-link');
                if (isComicBookmarked(comicId)) {
                    followLink.innerHTML = '<i class="fa fa-times"></i> <span>@lang('menu.unfollow_btn')</span>';
                    followLink.classList.remove('btn-success');
                    followLink.classList.add('btn-danger');
                } else {
                    followLink.innerHTML = '<i class="fa fa-heart"></i> <span>@lang('menu.follow_btn')</span>';
                    followLink.classList.remove('btn-danger');
                    followLink.classList.add('btn-success');
                }
            }

            updateFollowStatus(comicId);

            // Xử lý sự kiện click để thay đổi trạng thái theo dõi
            document.querySelector('.follow-link').addEventListener('click', () => {
                let bookmarkIds = JSON.parse(localStorage.getItem("bookmarkIds")) || [];

                // Nếu manga đã được theo dõi, bỏ theo dõi
                if (isComicBookmarked(comicId)) {
                    bookmarkIds = bookmarkIds.filter(id => id !== comicId);
                } else {
                    // Nếu manga chưa được theo dõi, thêm vào danh sách theo dõi
                    bookmarkIds.push(comicId);
                }

                // Cập nhật lại localStorage
                localStorage.setItem("bookmarkIds", JSON.stringify(bookmarkIds));

                // Cập nhật giao diện sau khi click
                updateFollowStatus(comicId);
            });
        });
    </script>
@endsection
