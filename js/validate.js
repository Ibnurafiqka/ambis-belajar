preConfirm: () => {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
  
    if (!username || !password) {
      Swal.showValidationMessage('Masukkan username dan password');
      return false;  // Return false untuk mencegah fetch jika validasi gagal
    }
  
    return fetch('login.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
    })
    .then(response => response.text())  // Ganti .json() dengan .text() untuk debugging
    .then(text => {
      try {
        const data = JSON.parse(text);  // Coba parsing JSON
        console.log('Data setelah parsing:', data);
  
        if (data.success) {
          window.location.href = data.redirectUrl;
        } else {
          Swal.showValidationMessage(data.message);
        }
      } catch (error) {
        console.error('Kesalahan parsing JSON:', error, text);
        Swal.showValidationMessage('Terjadi kesalahan pada server.');
      }
    })
    .catch(error => {
      console.error('Terjadi kesalahan:', error);
      Swal.showValidationMessage('Login gagal, coba lagi nanti');
    });
  }
  