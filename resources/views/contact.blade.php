@extends('layouts.app')

@section('content')
    <!-- Contact Section -->
    <section id="contact" class="contact section" style="background-color: #f0f0f0; color: #000;">
        <!-- Section Title -->
        <div class="container section-title" style="color: #000; margin-left: 100px; " >
            <h2>Contacto</h2>
            <p>Si tienes alguna consulta, por favor utiliza el siguiente formulario para contactarnos.</p>
        </div><!-- End Section Title -->

        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-5">
                    <div class="info-wrap" style="color: #000;">
                        <div class="info-item d-flex">
                            <i class="bi bi-geo-alt flex-shrink-0"></i>
                            <div>
                                <h3>Dirección</h3>
                                <p>#123 Calle Bolivar, Oruro</p>
                            </div>
                        </div><!-- End Info Item -->

                        <div class="info-item d-flex">
                            <i class="bi bi-telephone flex-shrink-0"></i>
                            <div>
                                <h3>Llámanos</h3>
                                <p>+591 75757575</p>
                            </div>
                        </div><!-- End Info Item -->

                        <div class="info-item d-flex">
                            <i class="bi bi-envelope flex-shrink-0"></i>
                            <div>
                                <h3>Escríbenos</h3>
                                <p>saunasanmarquez@gmail.com</p>
                            </div>
                        </div><!-- End Info Item -->

                        <!-- Google Map Integration -->
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3820.419192490688!2d-67.11679668446216!3d-17.96184778700198!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x93f5ab9e64e3dfd7%3A0x1f8b4b2f76f1e3f7!2sCalle%20Bol%C3%ADvar%20123%2C%20Oruro%2C%20Bolivia!5e0!3m2!1ses!2sus!4v1697298120386!5m2!1ses!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                        </div>
                </div>

                <div class="col-lg-7">
                    <!-- Mensajes de éxito o error -->
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Formulario de contacto -->
                    <form action="{{ route('contact.send') }}" method="POST" class="php-email-form" style="color: #000;">
                        @csrf
                        <div class="row gy-4">
                            <div class="col-md-6">
                                <label for="name-field" class="pb-2">Tu Nombre</label>
                                <input type="text" name="name" id="name-field" class="form-control" required="">
                            </div>

                            <div class="col-md-6">
                                <label for="email-field" class="pb-2">Tu Correo Electrónico</label>
                                <input type="email" class="form-control" name="email" id="email-field" required="">
                            </div>

                            <div class="col-md-12">
                                <label for="subject-field" class="pb-2">Asunto</label>
                                <input type="text" class="form-control" name="subject" id="subject-field" required="">
                            </div>

                            <div class="col-md-12">
                                <label for="message-field" class="pb-2">Mensaje</label>
                                <textarea class="form-control" name="message" rows="10" id="message-field" required=""></textarea>
                            </div>

                            <div class="col-md-12 text-center">
                                <button type="submit">Enviar Mensaje</button>
                            </div>
                        </div>
                    </form>
                </div><!-- End Contact Form -->
            </div>
        </div>
    </section><!-- /Contact Section -->
@endsection
