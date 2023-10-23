<?php include_once (VIEWS . 'header.php') ?>
<h2 class="text-center"><?= $data['title'] ?></h2>
<div class="alert mt-3">
    <?php if (isset($data['messageSent']) && $data['messageSent']) : ?>
        <div class="alert alert-success">El mensaje se ha enviado con éxito.</div>
    <?php elseif (isset($data['errors']) && count($data['errors']) > 0) : ?>
        <div class="alert alert-danger">
            <?php foreach ($data['errors'] as $error) : ?>
                <strong><?= $error ?></strong><br>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form action="<?= ROOT ?>shop/contact" method="POST">
        <div class="form-group text-left">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" required placeholder="Escriba su nombre" value="<?= isset($_POST['name']) ? $_POST['name'] : '' ?>">
        </div>
        <div class="form-group text-left">
            <label for="email">Correo electrónico</label>
            <input type="email" name="email" id="email" class="form-control" required placeholder="Escriba su correo electrónico" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>">
        </div>
        <div class="form-group text-left">
            <label for="message">Mensaje</label>
            <textarea name="message" id="message" cols="30" rows="10" class="form-control" value="<?= isset($_POST['message']) ? $_POST['message'] : '' ?>"></textarea>
        </div>
        <div class="mt-4 text-left">
            <input type="submit" value="Enviar" class="btn btn-info">
            <a href="<?= ROOT ?>shop" class="btn btn-secondary">Regresar</a>
        </div>
    </form>
</div>
<?php include_once (VIEWS . 'footer.php') ?>