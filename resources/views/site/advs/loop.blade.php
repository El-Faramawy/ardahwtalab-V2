<div class="items">
    <div class="row">
        <?php $dept=1; foreach ($advs as $ad): ?>
        @include('site.parts.advs_box')
        <?php endforeach; ?>
    </div>
</div>
<div class="text-center m-20">
    {{ $advs->links() }}
</div>