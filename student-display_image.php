<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display 360 Image</title>
    <!-- Import A-Frame and A-Frame Extras -->
    <script src="https://aframe.io/releases/1.2.0/aframe.min.js"></script>
    <script src="https://rawgit.com/donmccurdy/aframe-extras/master/dist/aframe-extras.min.js"></script>
    <script src="https://rawgit.com/donmccurdy/aframe-extras/master/dist/loaders/animation-mixer.min.js"></script>
    <script src="https://rawgit.com/donmccurdy/aframe-extras/master/dist/loaders/collada.min.js"></script>
    <style>
        /* CSS style for the images to have a fixed width and height */
        #imageContainer img {
            width: 300px; /* Adjust the width as needed */
            height: 200px; /* Adjust the height as needed */
            object-fit: cover; /* Preserve aspect ratio and cover container */
            transition: transform 0.2s; /* Add smooth transition on hover */
            cursor: pointer; /* Add pointer cursor on hover */
        }

        #imageContainer img:hover {
            transform: scale(1.1); /* Add zoom effect on hover */
        }

        #imageContainer p {
            margin: 8px 0;
        }

        /* CSS style for the modal */
        #imageModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1;
        }

        #imageModalContent {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            max-width: 90%;
            max-height: 90%;
        }

        #imageModal img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
    </style>
</head>
<body>
    <h1>House Display</h1>

    <!-- A-Frame scene to display the 360-degree image -->
    <a-scene embedded VR-mode-ui="enabled: true">

        <!-- Load the 360-degree image using <a-sky> entity -->
        <a-sky id="360Image" src="img/baiduri.jpeg" rotation="0 -130 0"></a-sky>

        <!-- Add a camera rig for VR mode -->
        <a-entity position="0 1.6 0">
            <a-entity camera look-controls wasd-controls></a-entity>
        </a-entity>

    </a-scene>

    <div id="imageContainer">
        <?php
        // Array of image filenames
        $imageFilenames = array('baiduri.jpeg', 'crystal_view.jpeg', 'suria_jaya.jpeg');
        
        // Array of image information corresponding to the filenames
        $imageInformation = array(
            array(
                'name' => 'Baiduri',
                'address' => 'Apartment Baiduri, Persiaran Tun Arshad Ayub, Seksyen 7, 40000 Shah Alam, Selangor',
                'price' => 'RM 400',
                'owner' => 'Zacky Zam',
                'description' => 'A beautiful house with stunning views.'
            ),
            array(
                'name' => 'Crystal View ',
                'address' => 'Seksyen 7, 40000 Shah Alam, Selangor',
                'price' => 'RM 350',
                'owner' => 'Hidayah Jusoh',
                'description' => 'Modern architecture with spacious rooms.'
            ),
            array(
                'name' => 'Suria Jaya ',
                'address' => 'beside school Seksyen 7, 40000 Shah Alam, Selangor',
                'price' => 'RM 300',
                'owner' => 'Kamal Adrul',
                'description' => 'simple home with a large porch.'
            )
        );
        
        // Get the selected image index from the query parameter (default to 0 if not set)
        $selectedImageIndex = isset($_GET['image']) ? intval($_GET['image']) : 0;
        
        // Ensure the selected index is within the valid range
        $selectedImageIndex = max(0, min(count($imageFilenames) - 1, $selectedImageIndex));
        
        // Output the images using the img tag based on the selected index
        foreach ($imageInformation as $index => $info) {
            $selected = ($index === $selectedImageIndex) ? 'selected' : '';
            echo '<img src="img/' . $imageFilenames[$index] . '" alt="' . $info['name'] . '" class="' . $selected . '">';
        }
        ?>
    </div>

    <a href="?image=<?php echo ($selectedImageIndex - 1 + count($imageFilenames)) % count($imageFilenames); ?>">Previous</a>
    <a href="?image=<?php echo ($selectedImageIndex + 1) % count($imageFilenames); ?>">Next</a>

    <!-- Modal to display more information when an image is clicked -->
    <div id="imageModal">
        <div id="imageModalContent">
            <img id="modalImage" src="" alt="Modal Image">
            <p id="modalImageName"></p>
            <p id="modalAddress"></p>
            <p id="modalPrice"></p>
            <p id="modalOwner"></p>
            <p id="modalDescription"></p>
        </div>
    </div>

    <script>
        const images = document.querySelectorAll('#imageContainer img');
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const modalImageName = document.getElementById('modalImageName');
        const modalAddress = document.getElementById('modalAddress');
        const modalPrice = document.getElementById('modalPrice');
        const modalOwner = document.getElementById('modalOwner');
        const modalDescription = document.getElementById('modalDescription');
        const skyImage = document.getElementById('360Image');

        images.forEach((image, index) => {
            image.addEventListener('click', () => {
                skyImage.setAttribute('src', 'img/' + <?php echo json_encode($imageFilenames); ?>[index]);
                modalImage.src = image.src;
                modalImageName.textContent = image.alt;
                modalAddress.textContent = 'Address: ' + <?php echo json_encode($imageInformation); ?>[index]['address'];
                modalPrice.textContent = 'Price: ' + <?php echo json_encode($imageInformation); ?>[index]['price'];
                modalOwner.textContent = 'Owner: ' + <?php echo json_encode($imageInformation); ?>[index]['owner'];
                modalDescription.textContent = 'Description: ' + <?php echo json_encode($imageInformation); ?>[index]['description'];
                modal.style.display = 'block';
            });
        });

        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });

        // New code to synchronize image and modal information
        const imageInformation = <?php echo json_encode($imageInformation); ?>;

        images.forEach((image, index) => {
            image.addEventListener('click', () => {
                const info = imageInformation[index];
                modalImage.src = image.src;
                modalImageName.textContent = info.name;
                modalAddress.textContent = 'Address: ' + info.address;
                modalPrice.textContent = 'Price: ' + info.price;
                modalOwner.textContent = 'Owner: ' + info.owner;
                modalDescription.textContent = 'Description: ' + info.description;
                modal.style.display = 'block';
            });
        });
    </script>
</body>
</html>