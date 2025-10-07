<ul class="social-list wow fadeInUp" data-wow-duration="2s">
    <li class="social-list__item">
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank"
           class="social-list__link flex-center">
            <i class="fab fa-facebook-f"></i>
        </a>
    </li>
    <li class="social-list__item">
        <a href="https://twitter.com/intent/tweet?text={{ $title ?? '' }}&amp;url={{ urlencode(url()->current()) }}"
           target="_blank" class="social-list__link flex-center active">
            <i class="fa-brands fa-x-twitter"></i>
        </a>
    </li>
    <li class="social-list__item">
        <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ urlencode(url()->current()) }}&amp;title={{ $title ?? '' }}&amp;summary={{ $description ?? '' }}"
           target="_blank" class="social-list__link flex-center">
            <i class="fa-brands fa-linkedin-in"></i>
        </a>
    </li>
    <li class="social-list__item">
        <a href="https://www.instagram.com/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank"
           class="social-list__link flex-center">
            <i class="fa-brands fa-instagram"></i>
        </a>
    </li>
    <li class="social-list__item">
        <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&amp;description={{ $description ?? '' }}&amp;media={{ $image }}"
           target="_blank" class="social-list__link flex-center">
            <i class="fa-brands fa-pinterest-p"></i>
        </a>
    </li>
    <li class="social-list__item">
        <a href="https://wa.me/?text={{ $title ?? '' }}%20{{ urlencode(url()->current()) }}" target="_blank"
           class="social-list__link flex-center">
            <i class="fa-brands fa-whatsapp"></i>
        </a>
    </li>
</ul>
