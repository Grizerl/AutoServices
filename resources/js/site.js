// Public website vendor bundle: everything is self-hosted (no blocking CDN requests).

// Icons and fonts
import '@fortawesome/fontawesome-free/css/all.min.css';
import '@fontsource/roboto/400.css';
import '@fontsource/roboto/500.css';
import '@fontsource/roboto/700.css';
import '@fontsource/roboto/900.css';
import '@fontsource-variable/open-sans';
import '@fontsource-variable/assistant';

// Sliders (exposed globally for public/assets/js/index.js)
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay, EffectFade, EffectFlip, A11y } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/effect-fade';
import 'swiper/css/effect-flip';

Swiper.use([Navigation, Pagination, Autoplay, EffectFade, EffectFlip, A11y]);
window.Swiper = Swiper;
