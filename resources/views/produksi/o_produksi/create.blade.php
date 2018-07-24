  <td>Nomor SPK</td>
  <td>
    <select class="form-control" id="mySelect" onchange="SetItem()">
      <option value=""> --Pilih SPK-- </option>
      @foreach ($dataSpk as $data)
      <option data-id="{{ $data->spk_id }}" data-iditem="{{ $data->spk_item }}" data-namaitem="{{ $data->i_name }}" data-jumlahitem="{{ $data->pp_qty }}" data-spk_ref="{{ $data->spk_ref }}" id="{{$data->spk_id}}" value="{{$data->spk_id}}">
        {{ $data->spk_code }}
      </option>
      @endforeach
    </select>
  </td>