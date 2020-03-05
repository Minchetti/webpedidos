    <div class="container">
      <form class="form-signin"  style="height: 420px">
        <div class="form-group">
            <img class="img-responsive center-block" src="<?php echo base_url('assets/images/logo/logoLogin.jpg'); ?>" alt="Fitassul" title="Fitassul"/>
        </div>
        <div class="form-group">
            <div class="alert alert-info">
                <p>
                    <strong><i class="glyphicon glyphicon-exclamation-sign"></i> Preencha <em>USUÁRIO</em> e <em>EMAIL</em> para poder receber uma nova senha.</strong>
                </p>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <label for="txtUsuario" class="sr-only">Usuário</label>
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input id="txtUsuario" type="text" class="form-control" placeholder="Usuário" aria-describedby="txtUsuario" autofocus />
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <label for="txtEmail" class="sr-only">Email</label>
                <span class="input-group-addon">@</span>
                <input id="txtEmail" type="email" class="form-control" placeholder="Email" aria-describedby="txtEmail" />
            </div>
        </div>
        <div class="form-group">
            <div id="avisos"></div>
        </div>
        <div class="form-group login-button">
            <button id="btn-enviar" class="btn btn-lg btn-danger btn-block" disabled><i class="glyphicon glyphicon-send"></i>Enviar</button>
        </div>
      </form>
    </div> <!-- /container -->