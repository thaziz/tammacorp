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
              <td>{{$data->ti_note}}</td>
              <td class="text-center">
                  <a onclick="edit('{{$data->ti_id}}')"    class="btn btn-warning btn-xs" title="Edit"   
                    @if($data->ti_isapproved=='Y') disabled @endif><i class="fa fa-check-circle-o"></i></a>
                  <a onclick="hapus('{{$data->ti_id}}')" class="btn btn-danger btn-xs" title="Hapus"
                    @if($data->ti_isapproved=='Y') disabled @endif><i class="fa fa-check-circle-o"></i></a>
              </td>
         
            </tr> 
            @endforeach
          </tbody>
</table>
<div  class="pull-right">
    {{$transferItem->links()}}
</div>
</div>


