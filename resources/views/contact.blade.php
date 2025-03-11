@extends('layouts.frontend')

@section('content')
<!--==================== HOME ====================-->
<section>
        <div class="swiper-container gallery-top">
          <div class="swiper-wrapper">
            <!--========== ISLANDS 1 ==========-->
            <section class="islands swiper-slide">
              <img
                src="{{ asset('frontend/assets/img/contact-hero.jpg') }}"
                alt=""
                class="islands__bg"
              />
              <div class="bg__overlay">
                <div class="islands__container container">
                  <div class="islands__data">
                    <h2 class="islands__subtitle">Need Travel</h2>
                    <h1 class="islands__title">Contact Us</h1>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </section>

      <style>
        .button {
          display: inline-flex; /* Menggunakan flexbox untuk menata elemen */
          align-items: center;   /* Memusatkan teks secara vertikal */
          justify-content: center; /* Memusatkan teks secara horizontal */
          padding: 10px 20px;
          font-size: 12px;
          color: #fff;
          background-color: #007bff;
          text-decoration: none; /* Menghapus garis bawah pada <a> */
          border: none;
          border-radius: 5px;
          cursor: pointer;
          transition: background-color 0.3s ease;
        }

        .button:hover {
          background-color: #0056b3; /* Warna saat hover */
        }
      </style>

      <!--==================== CONTACT ====================-->
      <section class="contact section" id="contact">
        <div class="contact__container container grid">
          <div class="contact__images">
            <div class="contact__orbe"></div>

            <div class="contact__img">
              <img src="{{ asset('frontend/assets/img/contact.jpg') }}" alt="" />
            </div>
          </div>

          <div class="contact__content">
            <div class="contact__data">
              <span class="section__subtitle">Need Help</span>
              <h2 class="section__title">Don't hesitate to contact us</h2>
              <p class="contact__description">
                Is there a problem finding places for yout next trip? Need a
                guide in first trip or need a consultation about traveling? just
                contact us.
              </p>
            </div>

            <div class="contact__card">
              <div class="contact__card-box">
                <div class="contact__card-info">
                  <i class="bx bxs-phone-call"></i>
                  <div>
                    <h3 class="contact__card-title">Call</h3>
                    <p class="contact__card-description">082199370439</p>
                  </div>
                </div>

                <a href="tel:+6282199370439" class="button contact__card-button">Call Now</a>
              </div>
              <div class="contact__card-box">
                <div class="contact__card-info">
                  <i class="bx bxs-message-rounded-dots"></i>
                  <div>
                    <h3 class="contact__card-title">Whatsapp</h3>
                    <p class="contact__card-description">+6282199370439</p>
                  </div>
                </div>
                <a href="https://wa.me/+6282199370439" target="_blank" class="button contact__card-button">Chat Now</a>
              </div>
              <div class="contact__card-box">
                <div class="contact__card-info">
                  <i class="bx bxs-video"></i>
                  <div>
                    <h3 class="contact__card-title">Video Call</h3>
                    <p class="contact__card-description">+6282199370439</p>
                  </div>
                </div>

                <a href="https://wa.me/+6282199370439?text=Hello%20I%20would%20like%20to%20start%20a%20video%20call" target="_blank" class="button contact__card-button">Video Call Now</a>
              </div>
              <div class="contact__card-box">
                <div class="contact__card-info">
                  <i class="bx bxs-phone-call"></i>
                  <div>
                    <h3 class="contact__card-title">Message</h3>
                    <p class="contact__card-description">082199370439</p>
                  </div>
                </div>

                <a href="mailto:satriadava29@gmail.com?subject=Inquiry&body=Hello,%0A%0AI%20would%20like%20to%20inquire%20about%20your%20services.%0A%0AThank%20you." target="_blank" class="button contact__card-button">Message Now</a>
              </div>
            </div>
          </div>
        </div>
      </section>
@endsection