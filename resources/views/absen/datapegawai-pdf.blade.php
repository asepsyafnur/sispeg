<!DOCTYPE html>
<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<head>
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
</style>
</head>
<body>

<h3>Laporan Absen Pegawai</h3>

<table id="customers">
    <thead>
        <tr>
          <th>#</th>
          <th>Nama</th>
          <th>Nip</th>
          <th>Tanggal</th>
          <th>Jam Masuk</th>
          <th>Jam Keluar</th>
          <th>Keterangan</th>
          <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pegawais as $value => $pegawai)
        <tr>
          <td>{{ $value + 1 }}</td>
          <td>{{ $pegawai->user->name }}</td>
          <td>{{ $pegawai->user->nip }}</td>
          <td>{{ date('d-m-Y', strtotime($pegawai->tanggal)) }}</td>
          <td>{{ $pegawai->kedatangan }}</td>
          <td>{{ $pegawai->kepulangan }}</td>
          <td>{{ $pegawai->keterangan }}</td>
          <td>{{$pegawai->status}}</td>
        </tr>    
        @endforeach
    </tbody>
</table>

</body>
</html>


