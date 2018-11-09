import { Component, OnInit } from '@angular/core';
import { Patient } from '../patient';

@Component({
  selector: 'app-patients',
  templateUrl: './patients.component.html',
  styleUrls: ['./patients.component.css']
})
export class PatientsComponent implements OnInit {
	currentPatient: Patient = {
		id: 1,
		name: 'Carla',
		lastNameP: 'Herrera',
		lastNameM: 'Rendón',
		gender: 1,
		birthDate: new Date('07/12/1995'),
		insurance: 'GNP',
		email: 'carla.herrera.rendon@gmail.com'
	};
	patients: Patient[] = [
		{ id: 1, name: 'Carla', lastNameP: 'Herrera', lastNameM: 'Rendón', gender: 1, birthDate: new Date('07/12/1995'), insurance: 'GNP', email: 'carla.herrera.rendon@gmail.com'
		},
		{ id: 2, name: 'Daniel', lastNameP: 'Herrera', lastNameM: 'Rendón', gender: 0, birthDate: new Date('06/04/1990'), insurance: 'GNP', email: 'daniel.herrera.rendon@gmail.com'
		}
	];
	showPatientDetails: boolean  = false;
	onSelect(pat: Patient): void {
		this.currentPatient = pat;
		this.showPatientDetails = true;
	}

  constructor() { }

  ngOnInit() {
  }

}
