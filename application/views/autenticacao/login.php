        <div class="container">
            <form class="form-signin">
                <div class="form-group">
                    <img class="img-responsive center-block" src="<?php echo base_url('assets/images/logo/logoLogin.jpg'); ?>" alt="Fitassul" title="Fitassul"/>
                </div>
        
            <div class="form-group">
                <div class="input-group">
                    <label for="txtUsuario" class="sr-only">Usuário</label>
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="txtUsuario" name="txtUsuario" type="text" class="form-control" placeholder="Usuário" aria-describedby="txtUsuario" autofocus />
                </div>
            </div>
            
            <div class="form-group">
                <div class="input-group">
                    <label for="txtSenha" class="sr-only">Senha</label>
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input id="txtSenha" type="password" class="form-control" placeholder="Senha" aria-describedby="txtSenha" />
                </div>
            </div>
        
            <div class="form-group">
                <div id="avisos"></div>
            </div>
        
            <div class="form-group login-button">
                <button id="btn-entrar" class="btn btn-lg btn-danger btn-block" disabled><i class="glyphicon glyphicon-log-in"></i> Entrar</button>
            </div>
            
            <div class="form-group">
                <a href="esqueci_senha" class="btn btn-link pull-right">Esqueci minha senha...</a>
            </div>
      </form>
    </div> <!-- /container -->