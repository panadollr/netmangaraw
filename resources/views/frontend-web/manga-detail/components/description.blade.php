<div class="detail-content">
    <h3 class="list-title">
        <i class="fa fa-file-text-o"></i> @lang('menu.manga_description')
    </h3>
    @if (strlen($manga->description) >= 274)
        <p id="description" class="shortened">{{ $manga->description }}</p>
        <a class="morelink">@lang('menu.view_more') <i class="fa fa-angle-right"></i></a>
    @else
        <p>{{ $manga->description }}</p>
    @endif

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.morelink').addEventListener('click', function(e) {
            e.preventDefault();
            let description = document.getElementById('description');
            if (description.classList.contains('shortened')) {
                description.classList.remove('shortened');
                this.innerHTML =
                    `@lang('menu.view_less') <i class="fa fa-angle-up"></i>`; // Thay đổi nút thành "Xem ít hơn"
            } else {
                description.classList.add('shortened');
                this.innerHTML =
                    `@lang('menu.view_more') <i class="fa fa-angle-right"></i>`; // Thay đổi nút thành "Xem thêm"
            }
        });
    });
</script>
