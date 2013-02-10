Set Data
----

Setting the data of a field can happen in many different ways. We
could be pulling the data out of a data repository (the database)
or parsing user input throuth the POST. Because of this the Field
object provides named methods for each. They are:

* setDataFromDatabase
* setDataFromPost