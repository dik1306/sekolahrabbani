@extends ('ortu.layouts.app')

@section('content')
    <div class="top-navigate sticky-top">
        <div class="d-flex" style="justify-content: stretch; width: 100%;">
            <a onclick="window.history.go(-1); return false;" class="mt-1" style="text-decoration: none; color: black">
                <i class="fa-solid fa-arrow-left fa-lg"></i>
            </a>
            <h4 class="mx-3"> Wishlist </h4>
            <span class="total_cart px-3 pt-1" > {{$wishlist->count()}} </span>
        </div>
    </div>

    @if ($wishlist->count() > 0)
    
        <?php $total = 0; ?>
        <div class="container pt-0">
            @foreach ($wishlist as $item)
                <div class="row-card" style="justify-content: center; align-items:center">
                    <div class="frame">
                        @if ($item->qty > 0)
                            <img src="{{asset('assets/images/'.$item->image)}}" width="100%" style="height: 100%; object-fit:cover; border-radius:1rem">
                        @else 
                            <img src="{{asset('assets/images/'.$item->image)}}" width="100%" style="height: 100%; object-fit:cover; border-radius:1rem; filter:brightness(0.5)">
                        @endif
                    </div>
                    <div class="deskripsi" style="width: 225px">
                        @if ($item->qty > 0)
                            <a href="{{route('seragam.detail', $item->id_produk)}}" style="text-decoration: none; color: #2C2C2C"> <h6 class="mb-1"><b> {{$item->nama_produk}} </b> </h6> </a>
                        @else 
                            <h6 class="mb-1"><b> {{$item->nama_produk}} </b> </h6>
                        @endif
                        <p class="mb-0 price-diskon"> <b> Rp. {{number_format((($item['harga']) - ($item['diskon']/100 * $item['harga'])) * $item['quantity']) }} </b> 
                            <span class="bg-danger py-1 px-2" style="font-size: 11px"> {{$item['diskon']}}% </span> 
                        </p>
                        <p class="mb-1" style="color: gray; font-size: 12px"> <s> Rp. {{number_format($item['harga'] * $item['quantity']) }} </s> </p>
                        <p class="mb-1" style="font-size: 11px"> Jenis: {{$item['jenis_produk']}}, <i> Size: {{$item['ukuran']}} </i> </p>
                        @if ($item->qty > 0)
                            <p class="mb-0" style="font-size: 12px"> <i> Ready Stock </i> </p>
                        @else
                            <p class="mb-0" style="font-size: 12px"> <i> Out of Stock </i> </p>
                        @endif
                        <div class="input-group" style="border: none;">
                            <form action="{{route('wishlist.delete', $item->id)}}" method="post" style="margin-left:auto">
                                @csrf @method('DELETE')
                                <button type="submit" style="border: none; background: none;" title="delete"><i class="fa-solid fa-heart" style="color: red"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

            
        </div>  
    @else
        <div class="center-cart">
            <h6> Wishlist Anda kosong saat ini </h6>
            <a href="{{route('seragam')}}" style="text-decoration: none">
                <button class="btn btn-primary px-3"> Belanja Sekarang</button>
            </a>
        </div>
    @endif

    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>

        $('.btn-number').click(function(e){
            e.preventDefault();
            
            fieldName = $(this).attr('data-field');
            type      = $(this).attr('data-type');
            id      = $(this).attr('data-id');
            var input = $("input[name='"+fieldName+"']");
            var currentVal = parseInt(input.val());
            var url = "{{ route('cart.update', ":id") }}";
            url = url.replace(':id', id);
            if (!isNaN(currentVal)) {
                if(type == 'minus') {
                    
                    if(currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();

                        $.ajax({
                            url: url,
                            type: 'PUT',
                            contentType: "application/x-www-form-urlencoded",
                            data: {
                                quantity: currentVal - 1,
                                 _token: '{{csrf_token()}}'
                            },
                            success: function (result) {
                               window.location.reload()
                            }
                        })
                        
                    } 
                    if(parseInt(input.val()) == 1) {
                        $(this).attr('disabled', true);
                    }

                } else if(type == 'plus') {

                    if(currentVal < input.attr('max')) {
                        input.val(currentVal + 1).change();

                        $.ajax({
                            url: url,
                            type: 'PUT',
                             contentType: "application/x-www-form-urlencoded",
                            data: {
                                quantity: currentVal + 1,
                                _token: '{{csrf_token()}}'

                            },
                            success: function (result) {
                               window.location.reload()

                            }
                        })

                    }
                    if(parseInt(input.val()) == input.attr('max')) {
                        $(this).attr('disabled', true);
                    }

                }
            } else {
                input.val(1);
            }
        });
        $('.input-number').focusin(function(){
        $(this).data('oldValue', $(this).val());
        });
        $('.input-number').change(function() {
            
            minValue =  parseInt($(this).attr('min'));
            maxValue =  parseInt($(this).attr('max'));
            valueCurrent = parseInt($(this).val());

            name = $(this).attr('name');
            if(valueCurrent >= minValue) {
                $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
            } else {
                alert('Sorry, the minimum value was reached');
                $(this).val($(this).data('oldValue'));
            }
            if(valueCurrent <= maxValue) {
                $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
            } else {
                alert('Sorry, the maximum value was reached');
                $(this).val($(this).data('oldValue'));
            }
            
            
        });
        $(".input-number").keydown(function (e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                    // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) || 
                    // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                        // let it happen, don't do anything
                        return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
        });

        function oncheck(id) {
            id = id;
            var status_check = $('#checklist-'+id).prop('checked');
            var url = "{{ route('cart-select.update', ":id") }}";
            url = url.replace(':id', id);
            var is_selected = null;
            if (status_check == true) {
                var is_selected = '1';
            } else {
                var is_selected = '0';
            }

            $.ajax({
                url: url,
                type: 'PUT',
                data: {
                    is_selected: is_selected,
                    _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    window.location.reload();
                }
            })
            
        }

        function getCheckedBoxes(main) {
            var checkboxes = document.getElementsByName('checklist-cart');
            var checks = ""; 
            var ids = ""; 
            // loop over them all
            for (var i=0; i<checkboxes.length; i++) {
                // And stick the checked ones onto an array...
                checkboxes[i].checked = main.checked
                checks += ( checkboxes[ i ].checked ) ? "1," : "0,";
                ids += checkboxes[i].id + ",";
                ids = ids.replace('checklist-', '')

            }

            $.ajax({
                type: "PUT",
                url: "{{route('select-all-cart')}}",
                data: {
                    checks: checks,
                    ids: ids,
                    _token: '{{csrf_token()}}'
                },
                success: function(msg){
                    var formatter = new Intl.NumberFormat("en-US");
                    var harga = formatter.format(msg)
                    if (harga != 0) {
                        $('#total_harga_keranjang').html(harga);
                        $('#btn-checkout').prop('disabled', false);
                    } else {
                        $('#total_harga_keranjang').html(harga);
                        $('#btn-checkout').prop('disabled', true);

                    }
                    
                }
            });
        }

    </script>

@endsection