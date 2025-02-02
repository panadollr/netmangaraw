<div id="ctl00_Breadcrumbs_pnlWrapper">
    <ul class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
        @foreach ($items as $index => $item)
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a class="itemcrumb {{ $item['active'] ? 'active' : '' }}" href="{{ $item['url'] }}" itemprop="item">
                    <span itemprop="name">{{ $item['label'] }}</span>
                </a>
                <meta content="{{ $index + 1 }}" itemprop="position">
            </li>
        @endforeach
    </ul>
</div>
