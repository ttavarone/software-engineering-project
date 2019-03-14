var docName = document.querySelector(#item);
var pageName

var docRef = db.collection("'.$page_name.'").doc("'.$doc.'");
docRef.get().then(function(doc) {
if (doc.exists) {
    console.log("Document data:", doc.data());
} else {
    // doc.data() will be undefined in this case
    console.log("No such document!");
}
}).catch(function(error) {
    console.log("Error getting document:", error);
});