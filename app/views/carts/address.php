<?php include_once (VIEWS . 'header.php') ?>
    <div class="card" id="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Iniciar Sesión</a></li>
                <li class="breadcrumb-item">Datos de envío</li>
                <li class="breadcrumb-item"><a href="#">Forma de pago</a></li>
                <li class="breadcrumb-item"><a href="#">Verificar los datos</a></li>
            </ol>
        </nav>
        <div class="card-header">
            <h1>Datos de envío</h1>
            <p>Por favor, compruebe los datos de envío y cambie lo que considere oportuno</p>
        </div>
        <div class="card-body">
            <form action="<?= ROOT ?>cart/updateAddress" method="POST">
                <div class="form-group text-left mb-2">
                    <label for="first_name">Nombre:</label>
                    <input type="text" name="first_name" id="first_name"
                           class="form-control" required
                           placeholder="Escribe tu nombre"
                           value="<?= $data['user']->first_name ?? '' ?>">
                </div>
                <div class="form-group text-left mb-2">
                    <label for="last_name_1">Primer apellido:</label>
                    <input type="text" name="last_name_1" id="last_name_1"
                           class="form-control" required
                           placeholder="Escribe tu primer apellido"
                           value="<?= $data['user']->last_name_1 ?? '' ?>">
                </div>
                <div class="form-group text-left mb-2">
                    <label for="last_name_2">Segundo apellido:</label>
                    <input type="text" name="last_name_2" id="last_name_2"
                           class="form-control"
                           placeholder="Escribe tu segundo apellido"
                           value="<?= $data['user']->last_name_2 ?? '' ?>">
                </div>
                <div class="form-group text-left mb-2">
                    <label for="email">Correo electrónico:</label>
                    <input type="email" id="email" name="email"
                           class="form-control" required
                           placeholder="Escriba su correo electrónico"
                           value="<?= $data['user']->email ?? '' ?>">
                </div>
                <div class="form-group text-left mb-2">
                    <label for="address">Dirección:</label>
                    <input type="text" name="address" id="address"
                           class="form-control" required
                           placeholder="Escribe tu dirección"
                           value="<?= $data['address']->address ?? '' ?>">
                </div>
                <div class="form-group text-left mb-2">
                    <label for="city">Ciudad:</label>
                    <input type="text" name="city" id="city"
                           class="form-control" required
                           placeholder="Escribe tu ciudad"
                           value="<?= $data['address']->city ?? '' ?>">
                </div>
                <div class="form-group text-left mb-2">
                    <label for="state">Provincia:</label>
                    <input type="text" name="state" id="state"
                    class="form-control" required
                    placeholder="Escribe tu provincia"
                    value="<?= $data['address']->state ?? '' ?>">
                </div>
                <div class="form-group text-left mb-2">
                    <label for="postcode">Código Postal:</label>
                    <input type="text" name="postcode" id="postcode"
                           class="form-control" required
                           placeholder="Escribe tu código postal"
                           value="<?= $data['address']->postcode ?? '' ?>">
                </div>
                <div class="form-group text-left mb-2">
                    <label for="country">País:</label>
                    <input type="text" name="country" id="country"
                           class="form-control" required
                           placeholder="Escribe tu país"
                           value="<?= $data['address']->country ?? '' ?>">
                </div>
                <div class="form-group text-left">
                    <input type="submit" value="Enviar datos" class="btn btn-success">
                </div>
            </form>
        </div>
    </div>
<?php include_once (VIEWS . 'footer.php') ?>