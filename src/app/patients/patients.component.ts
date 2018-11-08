import { Component, OnInit } from '@angular/core';
import { Patient } from '../patient';

@Component({
  selector: 'app-patients',
  templateUrl: './patients.component.html',
  styleUrls: ['./patients.component.css']
})
export class PatientsComponent implements OnInit {
	patient: Patient = {
		id: 1,
		name: 'Carla',
		lastNameP: 'Herrera',
		lastNameM: 'Rendón',
		gender: 1,
		birthDate: new Date('07/12/1995'),
		insurance: true,
		email: 'carla.herrera.rendon@gmail.com'
	};

  constructor() { }

  ngOnInit() {
  }

}
