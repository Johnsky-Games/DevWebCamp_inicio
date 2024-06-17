<main class="agenda">
    <h2 class="agenda__heading">Workshops y Conferencias</h2>
    <p class="agenda__descripcion">Talleres y Conferencias dicatados por expertos en desarrollo web</p>

    <div class="eventos">
        <h3 class="eventos__heading">&lt;Conferencias /></h3>
        <p class="eventos__fechas">Viernes 5 de Octubre</p>
        <div class="eventos__listado slider swiper">
            <div class="swiper-wrapper">
                <?php foreach ($eventos['conferencias_v'] as $evento) { ?>
                    <div class="evento swiper-slide">
                        <p class="evento__hora"> <?php echo $evento->hora->hora; ?></p>
                        <div class="evento__informacion">
                            <h4 class="evento__nombre"> <?php echo $evento->nombre; ?></h4>

                            <p class="evento__introduccion"> <?php echo $evento->descripcion; ?></p>

                            <div class="evento__autor-info">
                                <picture>
                                    <source srcset="img/speakers/<?php echo $evento->ponente->imagen; ?>.webp"
                                        type="image/webp">
                                    <source srcset="img/speakers/<?php echo $evento->ponente->imagen; ?>.png"
                                        type="image/png">
                                    <img class="evento__imagen-autor" loading="lazy" width="200" height="300"
                                        src="img/speakers/<?php echo $evento->ponente->imagen; ?>.png" alt="Imagen Ponente">
                                </picture>

                                <div class="evento__autor-nombre">
                                    <?php echo $evento->ponente->nombre . " " . $evento->ponente->apellido; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <p class="eventos__fechas">Sábado 6 de Octubre</p>
        <div class="eventos__listado slider swiper">
            <div class="swiper-wrapper">
                <?php foreach ($eventos['conferencias_s'] as $evento) { ?>
                    <div class="evento swiper-slide">
                        <p class="evento__hora"> <?php echo $evento->hora->hora; ?></p>
                        <div class="evento__informacion">
                            <h4 class="evento__nombre"> <?php echo $evento->nombre; ?></h4>

                            <p class="evento__introduccion"> <?php echo $evento->descripcion; ?></p>

                            <div class="evento__autor-info">
                                <picture>
                                    <source srcset="img/speakers/<?php echo $evento->ponente->imagen; ?>.webp"
                                        type="image/webp">
                                    <source srcset="img/speakers/<?php echo $evento->ponente->imagen; ?>.png"
                                        type="image/png">
                                    <img class="evento__imagen-autor" loading="lazy" width="200" height="300"
                                        src="img/speakers/<?php echo $evento->ponente->imagen; ?>.png" alt="Imagen Ponente">
                                </picture>

                                <div class="evento__autor-nombre">
                                    <?php echo $evento->ponente->nombre . " " . $evento->ponente->apellido; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>

    <div class="eventos eventos--workshops">
        <h3 class="eventos__heading">&lt;Workshops /></h3>
        <p class="eventos__fechas">Viernes 5 de Octubre</p>
        <div class="eventos__listado slider swiper">
            <div class="swiper-wrapper">
                <?php foreach ($eventos['workshops_v'] as $evento) { ?>
                    <div class="evento swiper-slide">
                        <p class="evento__hora"> <?php echo $evento->hora->hora; ?></p>
                        <div class="evento__informacion">
                            <h4 class="evento__nombre"> <?php echo $evento->nombre; ?></h4>

                            <p class="evento__introduccion"> <?php echo $evento->descripcion; ?></p>

                            <div class="evento__autor-info">
                                <picture>
                                    <source srcset="img/speakers/<?php echo $evento->ponente->imagen; ?>.webp"
                                        type="image/webp">
                                    <source srcset="img/speakers/<?php echo $evento->ponente->imagen; ?>.png"
                                        type="image/png">
                                    <img class="evento__imagen-autor" loading="lazy" width="200" height="300"
                                        src="img/speakers/<?php echo $evento->ponente->imagen; ?>.png" alt="Imagen Ponente">
                                </picture>

                                <div class="evento__autor-nombre">
                                    <?php echo $evento->ponente->nombre . " " . $evento->ponente->apellido; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <p class="eventos__fechas">Sábado 6 de Octubre</p>
        <div class="eventos__listado slider swiper">
            <div class="swiper-wrapper">
                <?php foreach ($eventos['workshops_s'] as $evento) { ?>
                    <div class="evento swiper-slide">
                        <p class="evento__hora"> <?php echo $evento->hora->hora; ?></p>
                        <div class="evento__informacion">
                            <h4 class="evento__nombre"> <?php echo $evento->nombre; ?></h4>

                            <p class="evento__introduccion"> <?php echo $evento->descripcion; ?></p>

                            <div class="evento__autor-info">
                                <picture>
                                    <source srcset="img/speakers/<?php echo $evento->ponente->imagen; ?>.webp"
                                        type="image/webp">
                                    <source srcset="img/speakers/<?php echo $evento->ponente->imagen; ?>.png"
                                        type="image/png">
                                    <img class="evento__imagen-autor" loading="lazy" width="200" height="300"
                                        src="img/speakers/<?php echo $evento->ponente->imagen; ?>.png" alt="Imagen Ponente">
                                </picture>

                                <div class="evento__autor-nombre">
                                    <?php echo $evento->ponente->nombre . " " . $evento->ponente->apellido; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</main>