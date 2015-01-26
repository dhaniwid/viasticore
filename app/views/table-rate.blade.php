<ul>
    <?php $index=0 ?>
    @foreach($occupancies as $occupancy)
    <ul>
        <?php $index++ ?>
        <div class="form-group">
            <label>{{$occupancy->occupancy_description}}</label><br>
            <input name='{{$occupancy->occupancy_description}}' type="text" placeholder="{{$occupancy->occupancy_description}} Sell Rate">
        </div>
    </ul>
    @endforeach  
    <input type='hidden' name='occupancy_id' value='{{$index}}'>    
</ul>

