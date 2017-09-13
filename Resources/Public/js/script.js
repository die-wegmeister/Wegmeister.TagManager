(() => {
	function qs(selector) {
		return document.querySelector(selector);
	}
	function qsAll(selector) {
		return document.querySelectorAll(selector);
	}

	const keys = qsAll('.add-val');
	const addValue = qs('.add-value');
	const additionalValues = qs('.additional-values');
	const addValueInput = qs('.additional-values label ~ input');
	const regex = /\[[^\[]*?\]$/;
	let index = 0;

	function updateName(e) {
		if (!this.value.match(/^([a-z][a-z0-9\-\_]*|)$/i)) {
			this.classList.add('error');
			this.title = 'The name must start with a letter. Only letters, numbers and the following characters are allowed: -_';
			return;
		}
		this.classList.remove('error');
		const selector = this.parentNode.getAttribute('for');
		const value = qs(`#${selector}`);

		value.name = value.name.replace(regex, `[${ this.value }]`);
	}

	keys.forEach(el => {
		el.addEventListener('keyup', updateName, false);
	});

	if (addValue !== null) {
		addValue.addEventListener('click', e => {
			e.preventDefault();
			index++;
			const addValueName = addValueInput.name.replace(regex, `[---]`);
			const li = document.createElement('li');
			const content = `<label for="additional-new-${index}">
						Name: <input type="text" class="add-val add-val--new">
					</label>
					Value: <input type="text" name="${addValueName}" id="additional-new-${index}" />`;

			li.innerHTML = content;
			additionalValues.appendChild(li);

			const newInput = qs('.add-val--new');
			newInput.addEventListener('keyup', updateName, false);
			newInput.classList.remove('add-val--new');
		}, false);
	}
})();
