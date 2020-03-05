<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title>Sistema de pedidos web | <?php echo $title; ?> | Fitassul</title>
    <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.ico'); ?>" type="image/x-icon">
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url('webpedidos/assets/css/dashboard.css'); ?>" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="<?php echo base_url('assets/css/font-awesome-4.7/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php 
        if(!empty($css)):
            foreach($css AS $style):
                print($style);
            endforeach;
        endif;
    ?>

</head>
<body>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-system">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- <a class="navbar-brand" href="<?php echo base_url('webpedidos/principal');?>">Fitassul</a> -->
                <a class="navbar-brand" href="<?php echo base_url('webpedidos/principal');?>" style="display: flex; align-items: center; margin-left: 10px; padding:0;">
                    <!-- <img class="" src="<?php echo base_url('webpedidos/assets/images/logof.JPG'); ?>" style="width: 120px;" alt="Fitassul" title="Fitassul"/> -->
                    <div style="font-size: 25px; font-weight: 900; display:flex;">
                        <span style="color: white;">FITA</span>
                        <!-- <span style="color: #d65050;">SS</span> -->
                        <span style="color: #c9302c;">SS</span>
                        <span style="color: white;">UL</span>                        
                    </div>
                </a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li>
                    <a href="<?php print(base_url('webpedidos/perfil')); ?>"><i class="fa fa-id-card" aria-hidden="true"></i> <?php (!empty($usuario)) ? print($usuario) : '' ?></a>
                </li>
                <li>
                    <a href="<?php print(base_url('webpedidos/sugestoes')); ?>"><i class="fa fa-commenting"></i> Sugestões</a>
                </li>
                <!--<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                        <li>
                            <a href="#">Alerta de informação <span class="label label-info">Info</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">Visualizar todas</a>
                        </li>
                    </ul>
                </li>-->
				 <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-question-circle-o" aria-hidden="true"></i> Ajuda <b class="caret"></b></a>
                    <ul class="dropdown-menu">
						<li>
                            <a href="<?php echo base_url('webpedidos/assets/arquivos/Manual_do_Usuario.pdf');?>" target="_blank"><i class="fa fa-book"></i> Manual</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="<?php print(base_url('webpedidos/logout'));?>"><i class="fa fa-power-off"></i> Sair</a>
                </li>
            </ul>


            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-main-system">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="<?php echo base_url('webpedidos/principal');?>"><i class="fa fa-desktop" aria-hidden="true"></i> Painel de avisos</a>
                    </li>
					<li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#order"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Requisições <i style="padding-left: 75px !important;" class="fa fa-caret-down" aria-hidden="true"></i></a>
                        <ul id="order" class="collapse">
                        <?php if($this->session->criarequisicao === true) : ?>   
                            <li>
                                <a href="<?php print(base_url('webpedidos/requisicao')); ?>"><i class="fa fa-plus" aria-hidden="true"></i> Nova</a>
                            </li>   
                    <?php endif; ?>
                            <?php if(filter_var($this->session->userdata('aprovador'), FILTER_VALIDATE_BOOLEAN)) :?>
                            <?php if($this->session->fiscal_empresa !== 2) : ?>
                            <li>
                                <a href="<?php print(base_url('webpedidos/aprovar_requisicoes')); ?>"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Aprovar</a>
                            </li>
                            <?php endif; ?>
                            <?php endif; ?>
                            <?php if($this->session->fiscal_empresa !== 2) : ?>
                            <li>
                                <a href="<?php print(base_url('webpedidos/listar_solicitacoes')); ?>"><i class="fa fa-hourglass-half" aria-hidden="true"></i> Solicitações</a>
                            </li>
                            <?php endif; ?>
							<li>
                                <a href="<?php print(base_url('webpedidos/localizar_requisicao'));?>"><i class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></i> Pedidos</a>
                            </li>
                        </ul>
                    </li>
                    <?php if($this->session->criatemplate === true) : ?>  
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#template"><i class="fa fa-clone" aria-hidden="true"></i> Template <i style="padding-left: 95px !important;" class="fa fa-caret-down" aria-hidden="true"></i></a>
                        <ul id="template" class="collapse">
                            <li>
                                <a href="<?php print(base_url('webpedidos/template_nova')); ?>"><i class="fa fa-plus" aria-hidden="true"></i> Criar</a>
                            </li>
                            <li>
                                <a href="<?php print(base_url('webpedidos/template'));  ?>"><i class="fa fa-list" aria-hidden="true"></i> Listar</a>
                            </li>
                        </ul>
                    </li>
     
                    <?php endif; ?>
                    <?php if($this->session->criausuario === true) : ?>                    
                    <li> 
                        <!-- <a href="javascript:;" data-toggle="collapse" data-target="#usuario"><i class="fa fa-user" aria-hidden="true"></i> Usuarios <i class="fa fa-caret-down" aria-hidden="true"></i></a> -->
                        <a href="<?php print(base_url('webpedidos/usuario')); ?>"><i class="fa fa-user" aria-hidden="true"></i> Usuários</a>
                        <ul id="usuario" class="collapse">
                            <li>
                                <a href="<?php print(base_url('webpedidos/usuario')); ?>"><i class="fa fa-plus" aria-hidden="true"></i> Criar</a>
                            </li>

                            <!-- <li>
                                <a href="<?php print(base_url('webpedidos/template'));  ?>"><i class="fa fa-list" aria-hidden="true"></i> Pesquisar</a>
                            </li> -->
                        </ul>
                    </li>                    
                    <?php endif; ?>


                    <li> 
                        <!-- <a href="javascript:;" data-toggle="collapse" data-target="#grupoacesso"><i class="fa fa-check" aria-hidden="true"></i> Grupos de Acesso <i class="fa fa-caret-down" aria-hidden="true"></i></a> -->
                        <a href="<?php print(base_url('webpedidos/grupoacesso')); ?>"><i class="fa fa-check" aria-hidden="true"></i> Grupos de Acesso</a>
                        <!-- <ul id="grupoacesso" class="collapse">
                            <li> 
                                <a href="<?php print(base_url('webpedidos/grupoacesso')); ?>"><i class="fa fa-check" aria-hidden="true"></i> Grupos de Acesso</a>
                            </li>
                        </ul> -->
                    </li>                    




                    <!-- RELATÒRIOS         Dei display none para esconder-->  
                    <li style='Display:block;'>
                    <?php if(in_array(TRUE, $relatorios, TRUE)) : ?>
                    <a href="<?php print(base_url('webpedidos/relatorios')); ?>"><i class="fa  fa-bar-chart-o" aria-hidden="true"></i> Relatórios</a>
                    <?php endif;?>

					<!--<a href="javascript:;" data-toggle="collapse" data-target="#report"><i class="fa  fa-bar-chart-o" aria-hidden="true"></i> Relatórios <i class="fa  fa-caret-down" aria-hidden="true"></i></a>
                        <ul id="report" class="collapse">
                            <li>
                                <a href="#"><i class="fa fa-line-chart" aria-hidden="true"></i> Consumo</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Aprovação</a>
                            </li>
						</ul>-->
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>