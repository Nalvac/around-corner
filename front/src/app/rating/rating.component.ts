import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-rating',
  templateUrl: './rating.component.html',
  styleUrls: ['./rating.component.scss']
})
export class RatingComponent implements OnInit {
  stars = [1, 2, 3, 4, 5];
  selectedRating = 0;
  comment = '';

  constructor() { }

  ngOnInit(): void { }

  setRating(rating: number): void {
    this.selectedRating = rating;
  }

  submitReview(): void {
    if (this.selectedRating && this.comment) {
      const review = {
        rating: this.selectedRating,
        comment: this.comment
      };
      console.log('Review submitted:', review);
      // Vous pouvez envoyer l'objet "review" à votre serveur pour le sauvegarder
      // Vous pouvez également ajouter un service pour gérer les avis et l'injecter ici
    } else {
      alert('Veuillez entrer une note et un commentaire.');
    }
  }
}
