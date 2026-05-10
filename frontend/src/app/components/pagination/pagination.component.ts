import { Component, input, output } from '@angular/core';

@Component({
  selector: 'app-pagination',
  standalone: true,
  templateUrl: './pagination.component.html',
})
export class PaginationComponent {
  currentPage = input<number>(1);
  lastPage = input<number>(1);

  pageChange = output<number>();

  change(page: number) {
    if (page < 1 || page > this.lastPage()) {
      return;
    }

    this.pageChange.emit(page);
  }
}
