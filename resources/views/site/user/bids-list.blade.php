<style type="text/css"> tr th,tr td{  text-align: center; border: solid 1px #000; padding:5px; }</style>
<table width="100%" border="solid 1px #000">
    <tr>
        <th>الاسم</th>
        <th>السعر</th>
        <th>التاريخ</th>
    </tr>
    @foreach($bids as $bd)
    <tr>
        <td><a target="_blank" href="{{ route('users.show',$bd->user()->first()->username) }}">{{ $bd->user()->first()->username }}</a></td>
        <td>{{ $bd->price }}</td>
        <td>{{ $bd->created_at }}</td>
    </tr>
    @endforeach
</table>