<form class="cmxform" id="commentForm" method="post" action="">
 <fieldset>
   <legend>A simple comment form</legend>
   <table>
   <?php echo $this->piform->render(); ?>
   </table>
 </fieldset>
 </form>
 <script>
  $(document).ready(function(){
    $("#commentForm").validate();
  });
  </script>