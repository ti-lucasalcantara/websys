<!-- MENU -->
<nav class="navbar navbar-expand-lg bg-white" style="padding-bottom:0 !important; padding-top:0 !important; ">
    <div class="container ">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navBarMenuSuperior" aria-controls="navBarMenuSuperior" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navBarMenuSuperior">
            <ul class="navbar-nav me-auto mb-lg-0 text-center">
                <li class="nav-item item-menu-superior" style="background-color: var(--sys_dash);">
                    <a href="<?=url_to('dashboard')?>" class="nav-link" aria-current="page" style="color:#FFF !important">
                        <i class="fa-solid fa-gauge"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item item-menu-superior" style="background-color: var(--sys_atendimento);">
                    <a href="#" class="nav-link" style="color:#FFF !important">
                        <i class="fa-solid fa-comments"></i> Atendimento
                    </a>
                </li>
                <li class="nav-item item-menu-superior" style="background-color: var(--sys_verde);">
                    <a href="<?=url_to('registro')?>" class="nav-link" style="color:#FFF !important">
                        <i class="fa-solid fa-users"></i> Inscrição/Registro
                    </a>
                </li>
                <li class="nav-item item-menu-superior" style="background-color: var(--sys_vermelho);">
                    <a href="<?=url_to('cobranca')?>" class="nav-link" style="color:#FFF !important">
                        <i class="fa-solid fa-dollar-sign"></i> Cobranças
                    </a>
                </li>
                <li class="nav-item item-menu-superior" style="background-color: var(--sys_azul);">
                    <a href="#" class="nav-link" style="color:#FFF !important">
                        <i class="fa-solid fa-search"></i> Fiscalização
                    </a>
                </li>
                <li class="nav-item item-menu-superior" style="background-color: var(--sys_roxo);">
                    <a href="#" class="nav-link" style="color:#FFF !important">
                        <i class="fa-solid fa-handshake"></i> Ética Profissional
                    </a>
                </li>
                <li class="nav-item item-menu-superior" style="background-color: var(--sys_marrom);">
                    <a href="#" class="nav-link" style="color:#FFF !important">
                        <i class="fa-solid fa-gavel"></i> Advocacia
                    </a>
                </li>
                <li class="nav-item item-menu-superior" style="background-color: var(--sys_laranja);">
                    <a class="nav-link" href="<?=url_to('adm')?>" style="color:#FFF !important">
                        <i class="fa-solid fa-gear"></i> Administrativo
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>