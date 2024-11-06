<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ambis Belajar - Kuis</title>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");
      :root {
        /* Font */
        --font-utama: "Poppins", serif;

        /* Warna Utama */
        --primary-color: #4e44ff;
        --secondary-color: #6c63ff;

        /* Tema Gelap */
        --dark-bg: #1a1a2e; /* Latar belakang utama gelap */
        --dark-secondary-bg: #25274d; /* Warna latar sekunder gelap */
        --dark-theme-bg: linear-gradient(
          135deg,
          var(--dark-bg) 0%,
          var(--dark-secondary-bg) 100%
        );
        --dark-text: #ffffff; /* Warna teks untuk tema gelap */

        /* Tema Terang */
        --light-bg: #f0f0f3; /* Latar belakang utama yang lembut dan netral */
        --light-secondary-bg: #e8eaf6; /* Warna sekunder untuk kartu atau elemen lain */
        --light-accent: #b8c1ec; /* Warna aksen ringan */
        --light-text: #4a4a4a; /* Warna teks utama */
        --light-border: #d1d1e0; /* Warna border lembut */
        --highlight-color: #009688; /* Warna aksen untuk tombol atau elemen interaktif */
        --light-theme-bg: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        --correct-color: #48bb78;
        --incorrect-color: #ff6b6b;
      }

      body {
        background: var(--dark-bg);
        color: var(--dark-text);
        font-family: var(--font-utama);
      }

      .quiz-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 2rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
      }

      .quiz-header {
        text-align: center;
        margin-bottom: 1.5rem;
      }

      .question-container {
        background: rgba(255, 255, 255, 0.05);
        padding: 1.5rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
      }

      .question {
        font-size: 1.2rem;
        font-weight: 600;
      }

      .options {
        list-style-type: none;
        padding: 0;
        margin-top: 1rem;
      }

      .option-item {
        margin-bottom: 0.5rem;
      }

      .option-label {
        display: flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.1);
        padding: 0.75rem;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
      }

      .option-label:hover {
        background: var(--primary-color);
      }

      .submit-btn {
        background: var(--primary-color);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        color: var(--dark-text);
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s ease;
      }

      .submit-btn:hover {
        background: #3a3aad;
      }

      .correct {
        background-color: rgba(72, 187, 120, 0.2);
      }

      .incorrect {
        background-color: rgba(255, 107, 107, 0.2);
      }

      .result-container {
        display: none;
        margin-top: 2rem;
        padding: 1.5rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
      }

      .result-correct {
        color: var(--correct-color);
      }

      .result-incorrect {
        color: var(--incorrect-color);
      }

      .statistic {
        display: flex;
        justify-content: space-between;
        font-size: 1rem;
        padding: 0.5rem 0;
      }

      .loader {
        display: none; /* Awalnya disembunyikan */
        border: 16px solid #f3f3f3; /* Light grey */
        border-top: 16px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 120px;
        height: 120px;
        margin: 0 auto; /* Untuk center */
        animation: spin 2s linear infinite;
      }

      @keyframes spin {
        0% {
          transform: rotate(0deg);
        }
        100% {
          transform: rotate(360deg);
        }
      }

      /* Tema Modal */
      .modal-content {
        background: var(--dark-bg); /* Latar belakang sekunder gelap */
        color: var(--dark-text); /* Warna teks untuk tema gelap */
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
      }

      .modal-body p {
        font-size: 18px;
        margin-top: 10px;
        color: var(--dark-text);
      }

      /* Tampilan Countdown */
      .countdown-number {
        font-size: 64px;
        font-weight: bold;
        color: var(--primary-color); /* Warna utama */
        transition: color 0.3s ease-in-out;
      }

      /* Efek Latar Belakang Setengah Gelap */
      .modal-backdrop.show {
        background-color: rgba(
          0,
          0,
          0,
          0.7
        ); /* Warna latar belakang transparan */
      }
    </style>
  </head>
  <body>
    <div class="quiz-container">
      <div class="quiz-header">
        <h2>Kuis Akhir Bab: Penerapan Konsep Stream</h2>
        <p>
          Jawab pertanyaan berikut dengan benar dan cek hasilnya di akhir kuis.
        </p>
      </div>

      <div class="question-container" id="questionContainer">
        <!-- Soal akan ditambahkan melalui JavaScript -->
      </div>

      <!-- Loader -->
      <div class="loader" id="loader" style="display: none"></div>

      <!-- Modal Bootstrap untuk countdown -->
      <div
        class="modal fade"
        id="countdownModal"
        tabindex="-1"
        aria-labelledby="countdownModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content p-4">
            <div class="modal-body text-center">
              <h3 id="countdownTimer" class="countdown-number">3</h3>
              <p>Anda akan diarahkan ke beranda...</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Tombol Submit -->
      <button class="submit-btn" id="submitBtn" onclick="simpanHasilKuis">
        Submit Jawaban
      </button>

      <div class="result-container" id="resultContainer">
        <h4>Hasil Kuis</h4>
        <p id="resultText"></p>
        <div class="statistic">
          <span>Total Benar:</span>
          <span id="correctCount"></span>
        </div>
        <div class="statistic">
          <span>Total Salah:</span>
          <span id="incorrectCount"></span>
        </div>
      </div>
    </div>

    <script>
      const questions = [
            {
                text: "Sebuah truk mengangkut barang dengan kecepatan konstan 60 kilometer per jam selama 3 jam. Berapakah total jarak yang ditempuh truk tersebut?",
                options: [
                    "A. 180 kilometer",
                    "B. 150 kilometer",
                    "C. 300 kilometer",
                    "D. 120 kilometer",
                ],
                answer: "A. 180 kilometer",
            },
            {
                text: "Jika sebuah toko buku menjual buku dengan diskon 20%, harga buku tersebut menjadi Rp40.000. Berapakah harga asli buku sebelum diskon?",
                options: ["A. Rp25.000", "B. Rp30.000", "C. Rp50.000", "D. Rp35.000"],
                answer: "C. Rp50.000",
            },
            {
                text: "SNBP memberikan peluang bagi siswa untuk masuk ke perguruan tinggi negeri berdasarkan prestasi. Berikut adalah beberapa komponen penilaian yang dipertimbangkan dalam SNBP, kecuali:",
                options: [
                    "A. Nilai rapor",
                    "B. Nilai ujian SNBT",
                    "C. Portofolio prestasi non-akademik",
                    "D. Piagam penghargaan lomba",
                ],
                answer: "B. Nilai ujian SNBT",
            },
            {
                text: "Dalam proses SNBP, salah satu faktor utama yang menjadi penilaian adalah prestasi akademik siswa selama SMA. Jika seorang siswa ingin meningkatkan peluang lolos SNBP, manakah di antara berikut yang paling disarankan?",
                options: ["A. Meningkatkan nilai rapor secara konsisten setiap semester", "B. Memilih jurusan yang memiliki persaingan paling rendah", "C. Mengikuti kegiatan ekstrakurikuler sebanyak mungkin", "D. Mengikuti bimbingan belajar khusus SNBP"],
                answer: "A. Meningkatkan nilai rapor secara konsisten setiap semester",
            },
            {
                text: "Jika sebuah pompa air mampu mengalirkan 3 liter air per menit, berapa banyak air yang dipompa dalam waktu 12 menit?",
                options: [
                    "A. 24 liter",
                    "B. 30 liter",
                    "C. 36 liter",
                    "D. 40 liter",
                ],
                answer: "C. 36 liter",
            },
        ];

      const questionContainer = document.getElementById("questionContainer");

questions.forEach((question, index) => {
  const questionDiv = document.createElement("div");
  questionDiv.className = "question-container";

  const questionText = document.createElement("p");
  questionText.className = "question";
  questionText.textContent = `Soal ${index + 1}: ${question.text}`; // Fixed template literals

  const optionList = document.createElement("ul");
  optionList.className = "options";

  question.options.forEach((option) => {
    const optionItem = document.createElement("li");
    optionItem.className = "option-item";

    const optionLabel = document.createElement("label");
    optionLabel.className = "option-label";
    optionLabel.innerHTML = `
      <input type="radio" name="question${index}" value="${option}" required />
      ${option}
    `;

    optionItem.appendChild(optionLabel);
    optionList.appendChild(optionItem);
  });

  questionDiv.appendChild(questionText);
  questionDiv.appendChild(optionList);
  questionContainer.appendChild(questionDiv);
});

document.getElementById("submitBtn").addEventListener("click", function () {
  // Tampilkan loader
  document.getElementById("loader").style.display = "block";

  let correctCount = 0;
  let incorrectCount = 0;

  questions.forEach((question, index) => {
    // Fixed template literals in querySelector
    const selectedOption = document.querySelector(`input[name="question${index}"]:checked`);

    const options = document.getElementsByName(`question${index}`);
    options.forEach((option) => {
      const label = option.closest("label");
      label.classList.remove("correct", "incorrect");
      label.querySelector("i")?.remove();
    });

    if (selectedOption) {
      const selectedLabel = selectedOption.closest("label");
      const icon = document.createElement("i");
      icon.style.marginLeft = "10px";

      if (selectedOption.value === question.answer) {
        correctCount++;
        selectedLabel.classList.add("correct");
        icon.className = "fas fa-check-circle";
        icon.style.color = "var(--correct-color)";
      } else {
        incorrectCount++;
        selectedLabel.classList.add("incorrect");
        icon.className = "fas fa-times-circle";
        icon.style.color = "var(--incorrect-color)";
      }
      selectedLabel.appendChild(icon);
    } else {
      incorrectCount++;
    }
  });

  // Sembunyikan loader
  document.getElementById("loader").style.display = "none";

  // Tampilkan hasil
  document.getElementById("correctCount").textContent = correctCount;
  document.getElementById("incorrectCount").textContent = incorrectCount;
  document.getElementById("resultText").textContent = `Kamu menjawab ${correctCount} dari ${questions.length} pertanyaan dengan benar!`;
  document.getElementById("resultContainer").style.display = "block";

  // Mulai countdown dengan animasi modal
  let countdown = 3;
  const countdownTimer = document.getElementById("countdownTimer");

  // Tampilkan modal
  const countdownModal = new bootstrap.Modal(document.getElementById("countdownModal"));
  countdownModal.show();

  const countdownInterval = setInterval(() => {
    countdownTimer.textContent = countdown;
    countdownTimer.style.color = countdown === 1 ? "#4e44ff" : "#4e44ff"; // Ubah warna pada detik terakhir
    countdown--;

    if (countdown < 0) {
      clearInterval(countdownInterval);
      countdownModal.hide(); // Sembunyikan modal
      window.location.href = "dashboard_sma.php"; // Redirect ke beranda
    }
  }, 1000);
});

// Fungsi untuk menghitung jawaban benar dan salah
function hitungHasilKuis() {
  let correctCount = 0;
  let incorrectCount = 0;

  // Periksa setiap pertanyaan
  questions.forEach((question, index) => {
    const selectedOption = document.querySelector(`input[name="question${index}"]:checked`); // Fixed template literals

    if (selectedOption) {
      if (selectedOption.value === question.answer) {
        correctCount++;
      } else {
        incorrectCount++;
      }
    }
  });

  return { correctCount, incorrectCount };
}

// Perbaiki definisi event handler
document.getElementById("submitBtn").onclick = function () {
  simpanHasilKuis();
};

function simpanHasilKuis() {
  const hasil = hitungHasilKuis();

  // Tampilkan hasil di halaman kuis
  document.getElementById("correctCount").textContent = hasil.correctCount;
  document.getElementById("incorrectCount").textContent = hasil.incorrectCount;

  // Tampilkan container hasil
  document.getElementById("resultContainer").style.display = "block";

  // Simpan ke localStorage
  localStorage.setItem(
    "quizResult",
    JSON.stringify({
      correctCount: hasil.correctCount,
      incorrectCount: hasil.incorrectCount,
    })
  );

  // Tunggu sebentar sebelum pindah halaman agar user bisa melihat hasil
  setTimeout(() => {
    window.location.href = "dashboard_sma.php";
  }, 2000);
}

    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  </body>
</html>