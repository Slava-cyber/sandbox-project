<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a href="" class="navbar-brand p-2">Sandbox</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarContent">
        <div class="container-fluid d-flex justify-content-end">
            <ul class="navbar-nav nav-pills mr-auto">
                <?php foreach ($navbar['main'] as $mainElement => $mainLink) : ?>
                <li class="nav-item text-center">
                    <a href="<?= $mainLink ?>"
                       class="nav-link
                       <?php echo (isset($navbar['active']) && $mainElement == $navbar['active']) ? "active" : "" ?>"
                       aria-current="main"><?= $mainElement ?>
                    </a>
                </li>
                <?php endforeach; ?>
                <?php if (isset($navbar['dropdown'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                           role="button" data-bs-toggle="dropdown" arai-expanded="false">
                            <img src="/images/system/profile1.png" alt="" width="40" height="40">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                            <?php foreach ($navbar['dropdown'] as $dropdownElement => $dropdownLink) : ?>
                                <?php if ($dropdownElement != 'divider') : ?>
                                    <li>
                                        <a class="dropdown-item" href="<?= $dropdownLink ?>"><?= $dropdownElement ?>
                                        </a>
                                    </li>
                                <?php else : ?>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>