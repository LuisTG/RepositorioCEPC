<?php
  use yii\bootstrap\Modal;
?>
<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src=<?php echo Yii::$app->user->identity->img_profile; ?> class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo Yii::$app->user->identity->name; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Bienvenido</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">ACCIONES</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Publicaciones</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="#" value="index.php?r=post/create" id="modalButton"><i class="fa fa-circle-o"></i> Crear</a></li>
            <li><a href="index.php?r=site/index-own"><i class="fa fa-circle-o"></i> Mis publicaciones</a></li>
            <!--<li><a href="#"><i class="fa fa-circle-o"></i> Buscar</a></li>-->
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Perfil</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="index.php?r=site/update">
            <i class="fa fa-circle-o"></i> Modificar Datos</a></li>
            <li><a href=<?php echo "index.php?r=site/activity-own&id=".Yii::$app->user->id; ?>><i class="fa fa-circle-o"></i> Mi actividad</a></li>
            <li><a method-data="post" data-confirm="Are you sure want to delete this account?" href=<?="index.php?r=site/delete-user&id=".Yii::$app->user->id; ?>><i class="fa fa-circle-o"></i> Eliminar cuenta</a></li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

    <?php
    Modal::begin([
        'header'=>'<h3>Create Post</h3>',
        'id'=>'modal',
        'size'=>'modal-lg',
        ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
    ?>