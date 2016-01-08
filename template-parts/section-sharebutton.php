<?php
// http://www.paulund.co.uk/social-sharing-links
// http://andornagy.com/flat-social-sharing-buttons-with-css/
?>

<div class="share clear" ontouchstart="this.classList.toggle('hover');">

  <div class="share--wrap">

    <?php // THIS DUMB SHIT IS FOR FACEBOOK
    function getUrl() {
      $url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
      $url .= ( $_SERVER["SERVER_PORT"] !== 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
      $url .= $_SERVER["REQUEST_URI"];
      return $url;
    }
    $encoded_url = urlencode( getUrl() ); ?>

    <ul class="share--buttons">
      <li><a href="https://twitter.com/intent/tweet?text=<?php the_title(); ?>&url=<?php the_permalink(); ?>&via=<?php bloginfo('name'); ?>" class="btn btn-twitter" target="_blank"><i class="_dg">twitter</i><span>Tweet</span></a></li>
      <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $encoded_url; ?>" class="btn btn-facebook" target="_blank"><i class="_dg">facebook</i><span>Share</span></a></li>
      <li><a href="javascript:void((function()%7Bvar%20e=document.createElement(&apos;script&apos;);e.setAttribute(&apos;type&apos;,&apos;text/javascript&apos;);e.setAttribute(&apos;charset&apos;,&apos;UTF-8&apos;);e.setAttribute(&apos;src&apos;,&apos;http://assets.pinterest.com/js/pinmarklet.js?r=&apos;+Math.random()*99999999);document.body.appendChild(e)%7D)());" class="btn btn-pinterest"><i class="_dg">pinterest</i><span>Pin</span></a></li>
      <li><a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" class="btn btn-google" target="_blank"><i class="_dg">google</i><span>Plus</span></a></li>
      <li><a href="mailto:?subject=From <?php bloginfo( 'name' ) ?>: <?php the_title(); ?>&amp;body=<?php the_permalink(); ?>" class="btn btn-email" target="_blank"><i class="_dg">email</i><span>Email</span></a></li>
    </ul>

    <?php // AND THIS CRAZY SHIT IS FOR PINTEREST
      // $image_id = get_field('hero_image');
      // $image_size = 'page-hero';
      // $image_array = wp_get_attachment_image_src($image_id, $image_size);
      // $image_url = $image_array[0];
    ?>

    <script type="javascript">
      $(document).ready(function() {
        $('.btn-pinterest').click(function() {
          $('.pinimglink').click();
        });
      });
    </script>

  </div>

  <div class="share--trigger">
    <button type="button" class="btn btn-primary"><i class="_dg icon-share"></i> <span>Share</span></button>
  </div>

</div>