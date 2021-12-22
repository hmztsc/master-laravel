<p>
   {{ empty(trim($slot)) ? 'Added' : $slot }} {{ $date->diffForHumans() }} 

   @if(isset($name))
   by {{ $name }}
   @endif
</p>