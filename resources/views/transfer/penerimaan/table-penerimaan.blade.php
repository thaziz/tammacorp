<div class="table-responsive no-padding">       
 <table class="table tabelan table-bordered no-padding" id="data4">
          <thead>
            <tr>
              <th width="7%">No</th>
              <th width="10%">Kode</th>              
              <th width="43%">Catatan</th>
              <th width="10%">Status</th>              
              <th width="10%">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($transferItem as $index=> $data)
            <tr>
              <td>{{  ($transferItem->currentpage()-1) * $transferItem->perpage() + $index + 1  }}</td>
              <td>{{$data->ti_code}}</td>
              <td>{{$data->ti_note}}</td>
              <td>
                  @if($data->ti_isapproved=='N' &&  $data->ti_issent=='N' &&  $data->ti_isreceived=='N')
                      <span class="label label-red">Waiting</span>
                  @elseif($data->ti_isapproved=='Y' &&  $data->ti_issent=='N' &&  $data->ti_isreceived=='N')
                      <span class="label label-yellow">Approved</span>
                  @elseif($data->ti_isapproved=='Y' &&  $data->ti_issent=='Y' &&  $data->ti_isreceived=='N')
                      <span class="label label-blue">Send</span>
                  @elseif($data->ti_isapproved=='Y' &&  $data->ti_issent=='Y' &&  $data->ti_isreceived=='Y')
                      <span class="label label-success">Received</span>
                  @endif
              </td>
              <td class="text-center">
            @if(Auth::user()->punyaAkses('Ritail Transfer','ma_insert'))
                @if($data->ti_isapproved=='Y' &&  $data->ti_issent=='Y' &&  $data->ti_isreceived=='N')
                  <a onclick="lihatPenerimaan('{{$data->ti_id}}')" class="btn btn-warning btn-xs" title="Penerimaan Barang"><i class="fa fa-chevron-circle-down"></i> &nbsp;Terima</a>               
                @else
                  <a onclick="lihatPenerimaan('{{$data->ti_id}}')" class="btn btn-warning btn-xs" title="Penerimaan Barang"><i class="fa fa-eye"></i> &nbsp;Terima</a>
                @endif
            @endif
              </td>
         
            </tr> 
            @endforeach
          </tbody>
</table>
<div  class="pull-right">
    {{$transferItem->links()}}
</div>
</div>


