<!DOCTYPE html>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1" >
        <title>Cadastro de Produtos</title>
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/node_modules/bootstrap/compiler/bootstrap.css">
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style/css/style.css">
    </head>
    <body>

        <nav class="navbar navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand h1 mb-0" href="<?php echo BASE_URL; ?>">Cadastro Z</a>

                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>">Home</a>
                    </li>
                </ul>

                <form class="form-inline" id="search-form" method="GET">
                    <input class="form-control ml-4 mr-2" name="input-search" type="search" placeholder="Busca por código ou nome">
                    <button class="btn btn-outline-light" type="submit" >Ok</button>
                </form>
            </div>
        </nav>

        <?php $this->loadViewInTemplate($viewName, $viewData); ?>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-12 mb-3">
                    <form method="POST">
                        <div class="form-row">
                            <div class="form-group col-sm-6 col-12">
                                <label for="input-name">Nome: </label>
                                <input type="text" class="form-control" name="input-name" id="input-name" required="required">
                            </div>
                            <div class="form-group col-sm-6 col-12">
                                <label for="input-cod">Código: </label>
                                <input typ="text" class="form-control" name="input-cod" id="input-cod" required="required">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-sm-6 col-12">
                                <label for="input-price">Preço: </label>
                                <input type="text" class="form-control" name="input-price" id="input-price" required="required">
                            </div>
                            <div class="form-group col-sm-6 col-12">
                                <label for="input-units">Unidades: </label>
                                <input type="text" class="form-control" name="input-units" id="input-units" required="required">
                            </div>
                        </div>

                        <div class="form-row justify-content-center">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-dark enviar" name="enviar">Cadastrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?php if (!empty($viewData['msg_add'])): ?>
                        <div class="alert <?php echo $viewData['class_msg']; ?> alert-dismissible fade show" role="alert"><?php echo $viewData['msg_add']; ?>
                            <button type="button" id="btn-close" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="jumbotron jumbotron-fluid mb-0">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h1 class="display-4">original de Lorem Ipsum</h1>
                        <p class="lead">
                            é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search-Modal -->
        <div class="modal fade" id="search-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Resultado da Busca</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="container-fluid" id="search-modal-content">
                            <div class="row">
                                <div class="col-6">
                                    <button type="button" class="btn btn-success btn-lg btn-block" data-dismiss="modal">Não</button>
                                </div>
                                <div class="col-6" id="col-rm-yes">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit-Modal -->
        <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Editar Produto</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="container" id="edit-modal-content">
                            <div class="row justify-content-center">
                                <div class="col-sm-12 mb-3">
                                    <form method="POST">
                                        <div class="form-row">
                                            <div class="form-group col-sm-6 col-12">
                                                <label for="input-name">Nome: </label>
                                                <input type="text" class="form-control" name="input-name" id="input-name" required="required" value="">
                                            </div>
                                            <div class="form-group col-sm-6 col-12">
                                                <label for="input-cod">Código: </label>
                                                <input typ="text" class="form-control" name="input-cod" id="input-cod" required="required" value="">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-sm-6 col-12">
                                                <label for="input-price">Preço: </label>
                                                <input type="text" class="form-control" name="input-price" id="input-price" required="required" value="">
                                            </div>
                                            <div class="form-group col-sm-6 col-12">
                                                <label for="input-units">Unidades: </label>
                                                <input type="text" class="form-control" name="input-units" id="input-units" required="required" value="">
                                                <input type="hidden" name="id" value="" >
                                            </div>
                                        </div>

                                        <div class="form-row justify-content-center">
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn btn-dark enviar" name="enviar">Editar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Remove-Modal -->
        <div class="modal fade" id="remove-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Remover produto?</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="container-fluid" id="remove-modal-content">
                            <div class="row">
                                <div class="col-6">
                                    <button type="button" class="btn btn-success btn-lg btn-block" data-dismiss="modal">Não</button>
                                </div>
                                <div class="col-6" id="col-rm-yes">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/css/node_modules/jquery/dist/jquery.js" ></script>
        <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/css/node_modules/popper.js/dist/umd/popper.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/css/node_modules/bootstrap/dist/js/bootstrap.js" ></script>
        <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/script.js" ></script>
    </body>
</html>
