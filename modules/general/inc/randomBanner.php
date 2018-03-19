<?php
/*** @ StevenDuc - Global OutSource Solutions ***/
// Do not change Code
function randomBanner($total)
{
  srand(time());
    for ($i=0; $i < $total; $i++)
    {
      $random = (rand()%$total);
      $slot[] = $random;
	  echo $slot[$i];
	  print_r($slot[$i]);
    }
	    
}

?>