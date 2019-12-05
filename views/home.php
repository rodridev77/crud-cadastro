
<div class="container pt-5" id="products-data">
    <div class="row">
        <div class="table-responsive justify-content-center">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Preço</th>
                        <th scope="col">Unidades</th>
                        <th scope="col">Importado</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <th scope="row" data-cod="<?php echo $item['codigo']; ?>" ><?php echo $item['codigo']; ?></th>
                            <td data-name="<?php echo $item['nome']; ?>" ><?php echo $item['nome']; ?></td>
                            <td data-price="<?php echo $item['preco']; ?>" ><?php echo "R$ " . number_format($item['preco'], 2); ?></td>
                            <td data-units="<?php echo $item['unidades']; ?>" ><?php echo $item['unidades']; ?></td>
                            <td data-id="<?php echo $item['id']; ?>"><?php echo ($item['importado']) ? "Sim" : "Não"; ?></td>
                            <td><a class="btn btn-outline-warning btn-block edit" href="javascript:" onclick="edit(this);" >Editar</a></td>
                            <td><a class="btn btn-outline-danger btn-block remove" href="javascript:" onclick="remove(<?php echo $item['id']; ?>);" >Remover</a></td >
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$hide_paginator = '';

if (($links['limit'] == 'all') || empty($items)) {
    $hide_paginator = 'd-none';
    $links['limit'] = '';
    $links['page'] = '';
    $links['start'] = '';
    $links['end'] = '';
    $links['last'] = '';
}
?>

<div class="container">
    <hr>
</div>
<div class="container <?php echo $hide_paginator; ?>" >
    <nav aria-label="Page navigation ">
        <ul class="pagination justify-content-center">
            <?php $class = ($links['page'] == 1) ? "disabled" : ""; ?>

            <?php if ($links['page'] == 1): ?>
                <li class="page-item <?php echo $class; ?>"><a class="page-link" href="#" tabindex="-1"><<</a></li>
            <?php else: ?>
                <li class="page-item <?php echo $class; ?>">
                    <a class="page-link" href="<?php echo BASE_URL; ?>index.php?page=<?php echo $links['page'] - 1; ?>" tabindex="-1"><<</a>
                </li>
            <?php endif; ?>

            <?php if ($links['start'] > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo BASE_URL; ?>index.php?page=1" tabindex="-1">1</a>
                </li>
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1"><span>...</span></a>
                </li>
            <?php endif; ?>

            <?php
            $i;
            for ($i = $links['start']; $i <= $links['end']; $i++):
                $class = ($links['page'] == $i) ? "active" : ""; // highlight current page
                ?>
                <li class = "page-item <?php echo $class; ?>">
                    <a class = "page-link" href = "<?php echo BASE_URL; ?>index.php?page=<?php echo $i; ?>"><?php echo $i; ?> <span class = "sr-only">(atual)</span></a>
                </li>
            <?php endfor; ?>

            <?php if ($links['end'] < $links['last']): ?>
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1"><span>...</span></a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="<?php echo BASE_URL; ?>index.php?page=<?php echo $links['last']; ?>" tabindex="-1"><?php echo $links['last']; ?></a>
                </li>
            <?php endif; ?>

            <?php
            $class = ($links['page'] == $links['last']) ? "disabled" : ""; // disable (>>> next page link)
            ?>

            <?php if ($links['page'] == $links['last']): ?>
                <li class="page-item <?php echo $class; ?>"><a class="page-link" href="#" tabindex="-1">>></a></li>
            <?php else: ?>
                <li class="page-item <?php echo $class; ?>">
                    <a class="page-link" href="<?php echo BASE_URL; ?>index.php?page=<?php echo $links['page'] + 1; ?>" tabindex="-1">>></a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

</div>

