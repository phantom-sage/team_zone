<form action="{{ route('reports.send.email') }}" method="POST">
    @csrf
    <input type="date" name="from_date">
    <input type="date" name="to_date">
    <input type="email" name="email" value="abdoeltayeb10@gmail.com">
    <input type="submit" value="Send">
</form>
