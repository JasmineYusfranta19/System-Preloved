<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Users Report</title>
</head>

<body style="margin:0; padding:0; background:#f1f5f9; font-family:Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:20px;">
        <tr>
            <td align="center">

                <table width="650" style="background:#ffffff; border-radius:8px; overflow:hidden;">


                    <tr>
                        <td style="background:#0f172a; color:#fff; padding:20px;">
                            <h2 style="margin:0;">👤 Users Report</h2>
                            <small>{{ now()->format('d M Y H:i') }}</small>
                        </td>
                    </tr>


                    <tr>
                        <td style="padding:20px;">
                            <p style="color:#555;">
                                Berikut adalah daftar user terbaru di sistem:
                            </p>

                            <table width="100%" cellpadding="8" cellspacing="0"
                                style="border-collapse:collapse; margin-top:15px;">
                                <thead>
                                    <tr style="background:#e2e8f0;">
                                        <th align="left">ID</th>
                                        <th align="left">Nama</th>
                                        <th align="left">Email</th>
                                        <th align="left">Tanggal Daftar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        <tr style="border-bottom:1px solid #eee;">
                                            <td>#{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" align="center">Tidak ada user</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </td>
                    </tr>


                    <tr>
                        <td style="background:#f8fafc; padding:15px; text-align:center; font-size:12px; color:#888;">
                            Total User: {{ $users->count() }} <br>
                            Email ini dibuat otomatis oleh sistem Laravel
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>