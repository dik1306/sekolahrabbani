{{-- <footer>
    <p>&copy; <script>document.write(new Date().getFullYear())</script> Web Sekolah Rabbani. All Rights Reserved</p>
</footer> --}}
<div class="footer">
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3">
            </div>
        </div>
        <div class="row">
            <div class="col-md">
                <div class="bg-logo mt-4" style="width: 25%">
                    <img src="{{ asset('assets/images/logo.png') }}" class="center" alt="logo" width="100%">
                </div>
                <h6 class="text-white mt-3"> Yayasan Rabbani Asysa </h6>
                <p class="text-white text-sm"> Jl. A.H. Nasution No.285, Pasanggrahan, Kec. Ujung Berung, Kota Bandung, Jawa Barat </p>
            </div>
            <div class="col-md-2 text-white mt-3">
                <h6> Halaman </h6>
                <a href="#" class="text-white" style="text-decoration: none"> Tentang Sekolah </a> <br>
                <a href="#" class="text-white" style="text-decoration: none"> Guru Karyawan </a> <br>
                <a href="#" class="text-white" style="text-decoration: none"> Sarana </a> <br>
                <a href="#" class="text-white" style="text-decoration: none"> Karir </a> <br>
            </div>
            <div class="col-md-2 text-white mt-3">
                <h6> Bantuan </h6>
                <a href="#" class="text-white" style="text-decoration: none"> Kebijakan Sekolah </a> <br>
                <a href="#" class="text-white" style="text-decoration: none"> FAQ </a> <br>
                <a href="#" class="text-white" style="text-decoration: none"> Kontak Kami </a> <br>
            </div>
            <div class="col-md text-white mt-3">
                <h6> Galeri </h6>
                <div class="slideshow-container">
                    <div class="mySlides fade">
                        <img src="{{ asset('assets/images/gallery_1.png') }}" style="max-height: 150px">
                    </div>
                    <div class="mySlides fade">
                        <img src="{{ asset('assets/images/gallery_4.png') }}" style="max-height: 150px">
                    </div>
                    <div class="mySlides fade">
                        <img src="{{ asset('assets/images/gallery_3.png') }}" style="max-height: 150px">
                    </div>
                </div>
            </div>
        </div>
       
    </div>
</div>

<script>
let slideIndex = 0;
showSlides();

function showSlides() {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}    
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
//   dots[slideIndex-1].classList += " active";
  setTimeout(showSlides, 3500); // Change image every 5 seconds
}
</script>