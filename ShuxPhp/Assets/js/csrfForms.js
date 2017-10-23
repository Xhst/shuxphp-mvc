function generateCsrfFields(Token)
{
	var forms = document.forms;

	for(var i = 0; i < forms.length; i++)
	{
		var input = document.createElement('input');
	    input.type = 'hidden';
	    input.name = 'csrf';
	    input.value = Token;
	    forms[i].appendChild(input);
	}
}