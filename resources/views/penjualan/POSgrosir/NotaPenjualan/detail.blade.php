<table class="table tabelan table-bordered table-hover" id="TbDtDetail">
    <thead>
      <tr>
        <th>No</th>
        <th width="25%">Item</th>
        <th>Jumlah</th>
        <th>Satuan</th>
        <th width="25%">Harga</th>
        <th width="5%">Disc Percent</th>
        <th width="25%">Disc Value</th>
        <th width="25%">Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($detalis as $index => $detail)
      <tr>
        <td>{{ $index+1 }}</td>
        <td>{{ $detail->i_name }}</td>
        <td><span class="pull-right"> 
              {{$detail->sd_qty}}
            </span>
        </td>
        <td>
          {{ $detail->m_sname }}
        </td>
        <td>Rp.
          <span class="pull-right">
          @if($detail->m_psell2 == '0' && $detail->m_psell3 == '0' )
            {{ number_format($detail->m_psell1,2,',','.')}}
          @elseif ($detail->m_psell1 == '0' && $detail->m_psell3 == '0')
            {{ number_format($detail->m_psell2,2,',','.')}}
          @else
            {{ number_format($detail->m_psell3,2,',','.')}}
          @endif
          </span>
        </td>
        <td><span class="pull-right">
          @if($detail->sd_disc_percent == null)
            0
          @else
            {{$detail->sd_disc_percent}}
          @endif
          %
        </span>
        </td>
        <td>Rp.
          <span class="pull-right">
          {{ number_format($detail->sd_disc_value,2,',','.')}}
          </span>
        </td>
        <td>Rp. 
          <span class="pull-right">
          {{ number_format($detail->sd_total,2,',','.')}}
          </span>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

<script>
   $('#TbDtDetail').DataTable();

</script>