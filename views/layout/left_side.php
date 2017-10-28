<aside class="left-side sidebar-offcanvas" style="min-height: 649px;padding-top: 0px;">
<!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar" style="margin-top: 0px;">
     <!-- Sidebar user panel -->
    <a href="../index.php">
     <div class="user-panel">
         <div class="pull-lexft image">
            <?php
              $user_data = get_user_data();
               if($user_data[2]==""){
                 $img = "../img/user/default.jpg";
               }else{
                 $img = "../img/user/".$user_data[2];
               } ?>
             <img src="<?= $img ?>" class="img-circle" alt="User Image" href="#"/>
         </div>
         <div class="pull-left info">
             <p><?php echo $user_data[0]; ?></p>
         </div>
     </div>
    </a>
     <!-- sidebar menu: : style can be found in sidebar.less -->
  <ul class="sidebar-menu">
  <?
  $menu_lv1 = menu_lv1($user_data[3]);
  while($row = mysql_fetch_array($menu_lv1)){
  $cek_menu_lv2 = cek_menu_lv2($user_data[3],$row['side_menu_id']);
  $menu_lv2 = menu_lv2($user_data[3],$row['side_menu_id']); ?>
   <li <? if($cek_menu_lv2 != 0){
             if ($_SESSION['menu_active']==$row['side_menu_id']) {?>
               class="active treeview"
               <?}else {?>
               class="treeview"
             <?}
           }?>>
             <a href="<?=$row['side_menu_url']?>">
                  <i class="<?=$row['side_menu_icon']?>"></i>
                 <span class="pull-right-container">
                   <?=$row['side_menu_name']?></span>
                 <? if($cek_menu_lv2 != 0){?> <i class="fa fa-angle-left pull-right"></i><? }?>
             </a>
             <?
             if (isset($_SESSION['sub_menu_active']) && $_SESSION['sub_menu_active']==true) {
         	    $sub_menu_active= $_SESSION['sub_menu_active'];
         	  }else {
         	    $sub_menu_active= 0;
         	  }
             if($cek_menu_lv2){?>
               <ul class="treeview-menu">
               <?
               while($row2 = mysql_fetch_array($menu_lv2)){?>
                 <li <?if($sub_menu_active==$row2['side_menu_id']){?>
                   class="active"
                   <?}?>>
                   <a href="<?=$row2['side_menu_url']?>"><?=$row2['side_menu_name']?></a></li>
               <? } ?>
               </ul>
               <? } ?>
   </li>
  <? } ?>
      <li class="" id="go_to_up" style="text-align:center;">
        <a href="#top">
          <i class="fa fa-arrow-circle-up"></i>
        </a>
      </li>
  </aside>
<script type="text/javascript">
  $("a[href='#top']").click(function() {
  $("html, body").animate({ scrollTop: 0 }, "slow");
    return false;
  });
</script>
