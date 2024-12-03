<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/contactus.css">
</head>
<body>
    <?php include 'header.php' ?>
    <section class="contact-us">
        <h1>Connect With Us</h1>
        <p>We would love to respont to your queries and help you succeed.
            <br> Feel free to get in touch with us.</p>
         <div class="contact-box">
            <div class="contact-left">
                <h3>Send your request</h3>
                <form action="">
                    <div class="input-row">
                        <div class="input-group">
                            <label for="name">Name</label>
                            <input type="text" name="" placeholder="Enter your Name" id="">
                        </div>
                        <div class="input-group">
                            <label for="name">Email</label>
                            <input type="text" name="" placeholder="Enter your Email" id="">
                        </div>
                        <div class="input-group">
                            <label for="name">Subject</label>
                            <input type="text" name="" placeholder="Enter Subject" id="">
                        </div>
                    </div>
                    <label for="">Message</label>
                    <textarea rows="5" placeholder="Enter your Message" name="" id=""></textarea>

                    <button type="submit">SEND</button>
                </form>
            </div>
            <div class="contact-right">
                <h3>Reach Us</h3>
                <table>
                    <tr>
                        <td>Email</td>
                        <td>bookpasal@gmail.com</td>
                    </tr>
                    <tr>
                        <td>Phone</td>
                        <td>+977- 97463116761 </td>
                    </tr>

                    <tr>
                        <td>Address</td>
                        <td>33700, Pokhara <br>
                        Nepal
                    </td>
                    </tr>
                </table>
            </div>
         </div>

    </section>
    <?php include 'footer.php' ?>
</body>
</html>