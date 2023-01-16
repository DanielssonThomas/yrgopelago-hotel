![This is an image](https://media.tenor.com/3cPsYV8nSOwAAAAC/cat-cleaning.gif)

# Nomi island

A wonderful warm place to relax

# Nomis Hotel

The Nomi Hotel has some truly fantastic rooms availabe, its the place to go for the great views and comfortable living. 
You can find our website here: https://thomasdanielsson.coffee/

# Instructions

If you want to review the code, press '.' while in this repository or clone it. 
If you clone it you may want to visit and try out the admin page. To use the Admin page enter 'Localhost:3000/Admin' you will need to insert your own password in a local .env file with the key "API_KEY" followed by the password of your choice like this 'API_KEY=Nomi'.

The Nomi Hotel also has an API that accepts the following form params:

BASE URL: https://thomasdanielsson.coffee/API/

| ENDPOINT | METHOD | DESCRIPTION | INPUT |
| -------- | ---------- | ------------- | -------|
| /bookings.php | POST | Books a selected date and room, and returns the log from a successful booking, or a status response of potential error in request |{'room': 'your-room', 'arrivalDate': 'your-arrival-date', 'departureDate': 'your-departure-date', 'transferCode': 'your-transferCode', [OPTIONAL]: 'features': array('sauna', 'tour', 'bed')}|
| /bookedRooms.php | POST | Displayes the database information for given bookingUID | 'bookingUID': 'your-bookingID'|



# Code review

1. index.php:2 - Remember to declare strict types to your PHP-files.
2. main-hotells.php:11-12 To keep consistent commenting, maybe add comment for where budget-room starts.
3. main-hotells.php:39 To keep consistent commenting, maybe add comment for where luxury-room starts.
4. main-hotells.php:14-15 Consider using WebP and AVIF formats for images for better compression and faster website!
5. typography.css:17—28 Add fallback-font to ensure text is user-visible while webfonts are loading.

More General comments:

6. Could be more comments! Although your variables are well-named so it’s quite easy to guess what different functions do.

7. Add a  menu to get an overview of the site’s content?

8. Does not display very well on mobile.

9. Add a calendar-design that better matches your elegant website-design!

10. The hand cursor over calendar indicates that it’s clickable even though it isn’t, consider changing it to an arrow cursor.

11. Lighthouse complains about Cumulative Layout Shift, but I didn’t really think about it when visiting your site. 

Overall, wow! Good job! :star2:
