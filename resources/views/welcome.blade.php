@extends('layouts.app')

@section('content')

<section class="hero">

        <div class="hero-text">
            <h1>معًا نصنع <span class="span">الأمل</span><br>ونبني المستقبل</h1>

            <p>
                منصة رائدنا الخير هي وجهتك الموثوقة للمساهمة في العمل الخيري وربط أصحاب الخير
                بالمستحقين بكل شفافية ومصداقية لتعزيز التكامل الاجتماعي
            </p>

           <div class="hero-buttons">
    <a href="{{ route('restaurant.register') }}" class="card-link">
        <button class="card">
            <div class="card-icon yellow">🏛️</div>
            <div class="card-text">
                <h4>سجل كمطعم / منشأة</h4>
                <span>(متبرع)</span>
            </div>
            <div class="card-arrow">←</div>
        </button>
    </a>

    <a href="{{ route('charity.register') }}" class="card-link">
        <button class="card">
            <div class="card-icon green">👥</div>
            <div class="card-text">
                <h4>سجل كجمعية خيرية</h4>
                <span>(مستفيد)</span>
            </div>
            <div class="card-arrow">←</div>
        </button>
    </a>
</div>
        </div>
        <div class="hero-img-wrapper">
            <img src="{{ asset('images/photo_5938386603279584500_x.jpg') }}" class="hero-img active">
            <img src="{{ asset('images/photo_5938386603279584501_x.jpg') }}" class="hero-img">
            <img src="{{ asset('images/photo_5938386603279584502_x.jpg') }}" class="hero-img">
        </div>


        <script>
            const images = document.querySelectorAll('.hero-img');
            let current = 0;

            function updateImages() {
                images.forEach(img => {
                    img.classList.remove('active', 'prev', 'back');
                });

                images[current].classList.add('active');
                images[(current + 1) % images.length].classList.add('prev');
                images[(current + 2) % images.length].classList.add('back');

                current = (current + 1) % images.length;
            }

            updateImages();
            setInterval(updateImages, 4000);
        </script>


    </section>

    <!-- Why Us -->
    <section class="why-us" id="why-us">
        <small>مميزاتنا</small>
        <h2>لماذا تختار زادنا الخير؟</h2>
        <div class="line"></div>

        <div class="features">

            <div class="feature-card">
                <div class="feature-icon blue">🛡️</div>
                <h3>موثوقية وشفافية</h3>
                <p>
                    ضمان وصول الدعم لمستحقيه بكل وضوح
                    ومتابعة دقيقة.
                </p>
            </div>


            <div class="feature-card">
                <div class="feature-icon yellow">👥</div>
                <h3>شراكة مجتمعية</h3>
                <p>
                    ربط بين الجمعيات الخيرية والمتبرعين لتعزيز
                    المسؤولية الاجتماعية.
                </p>
            </div>


            <div class="feature-card">
                <div class="feature-icon green">🤝</div>
                <h3>سهولة الاستخدام</h3>
                <p>
                    واجهة مستخدم بسيطة وسلسة تمكّنك من التبرع أو الاستفادة
                    بكل يسر.
                </p>
            </div>
        </div>
    </section>
    <!--    Faq -->
    <section class="faq" id="Faq">
        <div class="faq-header">
            <small>الدعم والمساعدة</small>
            <h2>الأسئلة الشائعة</h2>
            <p>إليك إجابات أكثر الأسئلة تداولًا حول المنصة</p>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                كيف يمكنني التسجيل كجمعية خيرية؟
                <span>⌄</span>
            </div>
            <div class="faq-answer">
                يمكنك التسجيل عبر إنشاء حساب جديد واختيار نوع الحساب (جمعية خيرية) ثم تعبئة البيانات المطلوبة.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                هل الخدمة مجانية؟
                <span>⌄</span>
            </div>
            <div class="faq-answer">
                نعم، استخدام منصة زادنا الخير مجاني بالكامل.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                كيف أضمن وصول تبرعاتي؟
                <span>⌄</span>
            </div>
            <div class="faq-answer">
                نضمن الشفافية من خلال تتبع التبرعات والتقارير الدورية.
            </div>
        </div>
    </section>

    <script>
        document.querySelectorAll('.faq-item').forEach(item => {
            item.addEventListener('click', () => {
                item.classList.toggle('active');
            });
        });
    </script>

    <!-- Contact Us -->
    <section class="contact" id="contact">
        <div class="contact-header">
            <small>تواصل معنا</small>
            <h2>نحن هنا لمساعدتك</h2>
            <div class="line"></div>
        </div>

        <div class="contact-container">

            <!-- معلومات التواصل -->
            <div class="contact-info">

                <div class="info-card">
                    <div class="info-icon email">✉️</div>
                    <div>
                        <h4>البريد الإلكتروني</h4>
                        <p>Zadnaelkahir@gmail.com</p>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-icon phone">📞</div>
                    <div>
                        <h4>الهاتف</h4>
                        <p>0598082027</p>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-icon location">📍</div>
                    <div>
                        <h4>المقر الرئيسي</h4>
                        <p>فلسطين - غزة</p>
                    </div>
                </div>

            </div>

            <!-- نموذج الإرسال -->
            <form class="contact-form">
                <h3>أرسل لنا رسالة</h3>

                <div class="form-group">
                    <input type="text" placeholder="الاسم">
                    <input type="email" placeholder="البريد الإلكتروني">
                </div>

                <input type="text" placeholder="الموضوع">

                <textarea placeholder="اكتب تفاصيل رسالتك هنا"></textarea>

                <button type="submit">إرسال الرسالة</button>
            </form>

        </div>
    </section>

   @endsection
