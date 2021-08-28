<style>
.header-style{
    background-color: antiquewhite;
    width: 95%;
    height: 10%;
    margin: 0px auto;
    text-align: center;
    font-size: 40px;
}
.main-style{
    width: 95%;
    height: 78%;
    margin: 5px auto;
    overflow: auto;

}
.footer-style{
    background-color: burlywood;
    width: 95%;
    height: 10%;
    margin: 0px auto;
    text-align: center;
    font-size: 40px;
    
}
</style>



<div class="header-style">
<?php include('view/header.php'); ?>
</div>

<div class="main-style">
<?php include('router.php'); ?>
</div>

<div class="footer-style">
<?php include('view/footer.php'); ?>
</div>