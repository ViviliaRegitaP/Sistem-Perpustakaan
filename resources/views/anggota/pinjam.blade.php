<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinjam Buku</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-[#F6F3F0] min-h-screen p-10">

    <div class="max-w-2xl mx-auto bg-white rounded-3xl shadow p-8">

        <h1 class="text-3xl font-bold text-[#2F3B2F] mb-8">
            Pinjam Buku
        </h1>

        <form>

            <div class="mb-5">
                <label class="block mb-2 font-semibold">
                    Nama Peminjam
                </label>

                <input 
                    type="text"
                    class="w-full border border-gray-300 rounded-xl p-3">
            </div>

            <div class="mb-5">
                <label class="block mb-2 font-semibold">
                    Judul Buku
                </label>

                <input 
                    type="text"
                    class="w-full border border-gray-300 rounded-xl p-3">
            </div>

            <div class="mb-5">
                <label class="block mb-2 font-semibold">
                    Tanggal Pinjam
                </label>

                <input 
                    type="date"
                    class="w-full border border-gray-300 rounded-xl p-3">
            </div>

            <div class="mb-8">
                <label class="block mb-2 font-semibold">
                    Tanggal Kembali
                </label>

                <input 
                    type="date"
                    class="w-full border border-gray-300 rounded-xl p-3">
            </div>

            <button
                type="submit"
                class="bg-[#A66E4E] hover:bg-[#8B5A3C] text-white px-6 py-3 rounded-xl transition">

                Pinjam Buku

            </button>

        </form>

    </div>

</body>
</html>