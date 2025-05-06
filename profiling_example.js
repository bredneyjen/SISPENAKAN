console.time('proses_lama');  // Mulai pengukuran waktu

function prosesLama() {
    return new Promise(resolve => {
        setTimeout(() => {
            console.log("Proses lama selesai");
            resolve();
        }, 2000);  // Simulasi proses yang memakan waktu 2 detik
    });
}

async function main() {
    await prosesLama();  // Panggil proses lama
    console.timeEnd('proses_lama');  // Akhiri pengukuran waktu
}

main();
