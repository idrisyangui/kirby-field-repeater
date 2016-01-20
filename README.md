# kirby-field-repeater

___** alpha version **___


Repeater is a field plugin for Kirby

Reapeter come with basic fields :
  - text
  - textarea
  - select
  - radio

This field work in a structure field or in a normal position. This field can be used for simple need of repeating, or in a structure field if you need another level of repeating.

## Installation and update

Copy the files to site/fields/repeater/.


## Usage

Use it in your blueprint:

**Case 1 in normal way**

```
fieldposition: non_structure
```
full configuration
```
steps:
		label: Etapes B
		type: repeater
		fieldposition: non_structure
		entry: >
			<p>
				<i>{{value.indice}}</i>
				<i>{{value.text}}</i>
			</p>
		fields:
			indice:
				label: Indice
				type: text
			text:
				label: Texte
				type: longtext
			textposition:
				label: Position
				type:  radio
				options:
					left: Gauche
					right: Droite
				
```

**Case 2 in a structure field**

```
fieldposition: structure
```

full configuration
  
```
items:
						label: Eléments
						type: repeater
						fieldposition: structure
						entry: >
							<p>
								<strong>{{value.indice}}</strong><br><br>
								<i>{{value.text}}</i><br>
								<em>{{value.textposition}}</em>
							</p>
						fields:
							marker:
								label: Marqueur
								type: text
							title:
								label: Titre
								type: text
							subtitle:
								label: Sous titre
								type: text
							text:
								label: Texte
								type: longtext
							image:
								label: Image
								type: text
							imagelegende:
								label: Legend
								type: text
							showmarker:
								label: Show the mark
								type: radio
								default: true
								options:
									true: Yes
									false: No
```
