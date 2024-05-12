<div class="share">
        <h3 class="share-with fixall">مشاركة عبر</h3>
        <div class="social">
                <a target="_blank" href="{{ 'https://www.facebook.com/sharer/sharer.php?u='.$info->link }}" class="social-link fixall">
                        <i class="fab fa-facebook-f"></i>
                </a>
                <a target="_blank" href="{{ 'https://twitter.com/intent/tweet?url='.$info->link.'&text='.$info->title }}"
                        class="social-link fixall">
                        <i class="fab fa-twitter"></i>
                </a>
                <a target="_blank" href="https://web.whatsapp.com/send?text={{$info->link}}" class="social-link fixall">
                        <i class="fab fa-whatsapp"></i>
                </a>
        </div>
</div>

<hr>
      @if($info->show_phone)
            <h4 class="share-with fixall">تواصل مع البائع عبر الرقم : </h4>
<br>
                        <h4 class="share-with fixall">{{ $info->user->phone }}</h4>


                        @endif
      