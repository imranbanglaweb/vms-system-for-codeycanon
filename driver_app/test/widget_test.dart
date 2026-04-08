import 'package:flutter_test/flutter_test.dart';

import 'package:vms_driver/app.dart';

void main() {
  testWidgets('App loads successfully', (WidgetTester tester) async {
    await tester.pumpWidget(const VmsDriverApp());
    await tester.pumpAndSettle();
  });
}
